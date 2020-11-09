<?php

namespace App\Modules\AppUser\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Admin;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use App\Modules\AppUser\Models\TargetType;
use App\Modules\Admin\Models\ServiceCharge;
use App\Modules\AppUser\Models\Transaction;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\ValidationException;
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Models\PaystackTransaction;
use App\Modules\AppUser\Notifications\NewSavingsSuccess;
use App\Modules\AppUser\Notifications\TargetSavingsBroken;
use App\Modules\Admin\Transformers\AdminSavingsTransformer;
use App\Modules\AppUser\Notifications\TargetSavingsMatured;
use App\Modules\AppUser\Notifications\SmartSavingsInitialised;
use App\Modules\Admin\Notifications\SavingsMaturedNotification;
use App\Modules\AppUser\Http\Requests\CreateTargetFundValidation;
use App\Modules\AppUser\Http\Requests\SetAutoSaveSettingsValidation;
use App\Modules\AppUser\Http\Requests\InitialiseSmartSavingsValidation;

class Savings extends Model
{
  use SoftDeletes;

  protected $fillable = ['type', 'target_type_id', 'maturity_date', 'amount', 'interests_withdrawable'];
  protected $table = 'savings';
  protected $dates = ['funded_at', 'maturity_date', 'withdrawn_at', 'interests_unlocked_at'];
  protected $casts = [
    'current_balance' => 'double',
    'app_user_id' => 'int',
    'target_type_id' => 'int',
    'is_liquidated' => 'boolean',
    'interests_withdrawable' => 'boolean',
  ];

  public function service_charges()
  {
    return $this->hasMany(ServiceCharge::class);
  }

  public function app_user()
  {
    return $this->belongsTo(AppUser::class);
  }

  public function withdrawalRequest()
  {
    return $this->hasOne(WithdrawalRequest::class)->userVerified();
  }

  public function target_type()
  {
    return $this->belongsTo(TargetType::class)->withDefault(function ($user, $post) {
      $user->name = $post->type;
    });
  }

  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }

  public function withdrawal_transactions()
  {
    return $this->transactions()->where('trans_type', 'withdrawal');
  }

  public function deposit_transactions()
  {
    return $this->transactions()->where('trans_type', 'deposit');
  }

  public function initial_deposit_transaction()
  {
    return $this->hasOne(Transaction::class)->oldest();
  }

  public function savings_interests()
  {
    return $this->hasMany(SavingsInterest::class);
  }

  public function unprocessed_savings_interests()
  {
    return $this->savings_interests()->unprocessed();
  }

  public function processed_savings_interests()
  {
    return $this->savings_interests()->processed();
  }

  public function belongs_to(AppUser $user): bool
  {
    return $user->is($this->app_user);
  }

  public function is_active(): bool
  {
    return !$this->is_liquidated || !$this->is_mature();
  }

  public function is_smart_savings(): bool
  {
    return $this->type == 'smart';
  }

  public function is_target_savings(): bool
  {
    return $this->type == 'target';
  }

  public function total_deposits_sum(): float
  {
    return $this->deposit_transactions()->sum('amount');
  }

  public function total_withdrawals_sum(): float
  {
    return $this->withdrawal_transactions()->sum('amount');
  }

  public function total_accrued_interest_amount(): float
  {
    return $this->savings_interests()->sum('amount');
  }

  public function total_unprocessed_interest_amount(): float
  {
    return $this->unprocessed_savings_interests()->sum('amount');
  }

  public function total_processed_interest_amount(): float
  {
    return $this->processed_savings_interests()->sum('amount');
  }

  public function get_due_interest(): float
  {

    if (!$this->is_active()) {
      return 0;
    }
    /**
     * Handle withdrawals. so you dont give interest on deposits that have been "withdrawn"
     * -- Only smart savings have withdrawals
     */
    if ($this->is_smart_savings()) {
      return $this->transactions()->deposits()->interestable()->sum('amount') * (config('app.smart_savings_interest_rate') / 100);
    } else if ($this->is_target_savings()) {
      return $this->transactions()->deposits()->interestable()->sum('amount') * (config('app.target_savings_interest_rate') / 100);
    }
  }

  public function mark_interest_as_processed(): bool
  {
    /**
     * Mark all interestable transactions as processed
     */
    return $this->transactions()->deposits()->interestable()->update(['interest_processed_at' => now()]);
  }

  public function rollover_uncleared_interests(string $decsription = null): ?float
  {
    try {
      /**
       * Get sum of uncleared interests
       */
      $uncleared_interests_sum = $this->savings_interests()->unlocked()->unprocessed()->sum('amount');

      if ($uncleared_interests_sum <= 0) {
        return 0;
      }

      /**
       * Add a deposit transaction for this savings with a description for interest roll over
       */
      $decsription = $decsription ?? 'Quarterly rollover of interest for ' . $this->target_type->name . ' savings';

      $this->create_deposit_transaction($uncleared_interests_sum, $decsription);

      /**
       * Mark all the interests as cleared
       */
      $this->savings_interests()->unlocked()->unprocessed()->update([
        'processed_at' => now(),
        'process_type' => 'matured'
      ]);

      /**
       * Add the accrued interest amount to this saving's current_balance to be displayed in the vault
       */
      $this->current_balance += $uncleared_interests_sum;
      $this->save();

      /**
       * Return success
       */
      return $uncleared_interests_sum;
    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail($this->app_user, $th, 'Failed to rollover uncleared interests');
      /**
       * Return null on failure
       */
      return null;
    }
  }

  public function is_mature(): ?bool
  {
    /**
     * Check if the maturity date is up to today
     */
    return $this->maturity_date->lte(now());
  }

  public function complete_mature_savings(): bool
  {
    /**
     * Make sure this is not a withdrawn or immature target savings
     */
    if (!$this->is_mature() || $this->is_withdrawn) {
      return false;
    }

    DB::beginTransaction();

    /**
     * Unlock all accrued interests so that they can be withdrawn
     */
    $this->savings_interests()->locked()->unprocessed()->update([
      'is_locked' => false,
    ]);

    /**
     * Handle uncleared profits.
     *
     * * The uncleared profits ae added to this savings' current_balance and then marked as cleared
     * ? If return is null, then an error occured
     *
     * @return ?float
     */
    if (is_null($this->rollover_uncleared_interests('Interests Rolled over at savings maturity'))) {
      return false;
    }
    DB::commit();

    return true;
  }

  public function create_deposit_transaction(float $amount, string $desc): Transaction
  {
    return $this->transactions()->create([
      'trans_type' => 'deposit',
      'amount' => $amount,
      'description' => $desc
    ]);
  }

  public function create_withdrawal_transaction(float $amount, string $desc): Transaction
  {
    return $this->transactions()->create([
      'trans_type' => 'withdrawal',
      'amount' => $amount,
      'description' => $desc,
      'yields_interest' => false
    ]);
  }

  public function create_service_charge(float $amount, string $desc): ServiceCharge
  {
    return $this->service_charges()->create([
      'amount' => $amount,
      'description' => $desc
    ]);
  }

  public function create_interest_record(float $amount): SavingsInterest
  {
    return $this->savings_interests()->create([
      'amount' => $amount
    ]);
  }

  public function is_balance_consistent(): bool
  {
    return $this->current_balance === ($this->total_deposits_sum() - $this->total_withdrawals_sum());
  }

  public function unlockSavingsInterests(): bool
  {

    $this->savings_interests()->locked()->unprocessed()->update([
      'is_locked' => false
    ]);

    return true;
  }

  public function liquidate(): void
  {
    DB::beginTransaction();
    /**
     * Liquidate all pending interests
     */
    $this->savings_interests()->locked()->unprocessed()->update([
      'processed_at' => now(),
      'process_type' => 'liquidated'
    ]);

    /**
     * Get the previous awarded interests (those that passed the 90 day benchmark cycle)
     * ! Roll it over into the user's smart savings balance
     * @var float $accruedInterests
     */
    $accruedInterests = $this->savings_interests()->unlocked()->unprocessed()->sum('amount');
    $this->current_balance += $accruedInterests;

    /**
     * Create a deposit transaction of this rollover for user's records
     */
    if ($accruedInterests > 0) {
      $this->transactions()->create([
        'type' => 'deposit',
        'amount' => $accruedInterests,
        'yields_interests' => false,
        'description' => 'Rollover of accumulated interests into smart savings balance'
      ]);
    }

    $this->is_liquidated = true;
    $this->save();

    DB::commit();
  }

  public function unprocessedTotalInterestsAmount(): float
  {
    return $this->savings_interests()->unprocessed()->sum('amount');
  }

  public function unlockedUnprocessedTotalInterestsAmount(): float
  {
    return $this->savings_interests()->unprocessed()->unlocked()->sum('amount');
  }

  public function isDueForInterestsWithdrawal(): bool
  {
    // check if this portfolio is old enough to have interests withdrawn
    if ($this->funded_at->diffInDays(now()) > config('app.smart_savings_minimum_duration_before_interests_withdrawal')) {
      return false;
    }

    // check if this savings interests has grown to min treshold for interests withdrawal
    if ($this->unlockedUnprocessedTotalInterestsAmount() < config('app.smart_savings_minimum_amount_before_interests_withdrawal')) {
      return false;
    }

    return true;
  }

  public function isDueForIntetestsUnlock(): bool
  {
    if (is_null($this->interests_unlocked_at) && $this->funded_at->diffInDays(now()) > config('app.smart_savings_minimum_duration_before_interests_withdrawal')) {
      return true;
    }
    /**
     * check if interests was unlocked in the last config('app.smart_savings_minimum_duration_before_interests_withdrawal') days
     */

    if (optional($this->interests_unlocked_at)->diffInDays(now()) < config('app.smart_savings_minimum_duration_before_interests_withdrawal')) {
      return false;
    }
    return true;
  }

  public function is_due_for_free_withdrawal(): bool
  {
    /**
     * check if it is liquidated
     * check if withdrawal was done in last 20 days
     */

    if (
      $this->is_liquidated
      // $this->previous_withdrawal_requests()->whereMonth('created_at', now()->month)->exists() ||
      // $this->previous_withdrawal_requests()->whereDate('created_at', '>=', now()->subDays(20))->exists()
    ) {
      return false;
    }
    return true;
  }

  public function getTotalDurationAttribute(): int
  {
    return optional($this->maturity_date)->diffInDays($this->funded_at);
  }

  public function getIsWithdrawnAttribute(): bool
  {
    return !is_null($this->withdrawn_at);
  }

  public function getElapsedDurationAttribute(): int
  {
    return optional($this->maturity_date)->diffInDays(now());
  }

  static function adminRoutes()
  {
    Route::get('{user}/savings', [self::class, 'adminViewUserSavings'])->name('admin.user_savings')->defaults('extras', ['nav_skip' => true]);
    Route::post('{appUser}/savings/target-funds/add', [self::class, 'lockMoreUserFunds'])->name('admin.user_savings.target.fund');
    Route::post('{appUser}/savings/target-funds/deduct', [self::class, 'deductUserFunds'])->name('admin.user_savings.target.defund');
    Route::get('notifications/matured-savings', [self::class, 'getMaturedSavingsNotifications'])->name('admin.view_matured_savings')->defaults('extras', ['icon' => 'fas fa-clipboard-list']);
  }

  static function appUserRoutes()
  {
    Route::get('savings', [self::class, 'viewUserSavings'])->name('appuser.savings')->defaults('extras', ['icon' => 'fas fa-wallet']);
    Route::post('/savings/auto-save/create', [self::class, 'setAutoSaveSettings'])->name('appuser.savings.create-autosave');
    Route::delete('/savings/auto-save/{autoSaveSetting}', [self::class, 'deleteAutoSaveSettings'])->name('appuser.savings.delete-autosave');
    Route::post('/savings/target-funds/add', [self::class, 'lockMoreFunds'])->name('appuser.savings.target.fund');
    Route::get('/savings/{savings}/target-funds/add', [self::class, 'verifyLockMoreFunds'])->name('appuser.savings.target.fund.verify')->defaults('extras', ['nav_skip' => true]);
    Route::get('/savings/{savings}/verify', [self::class, 'verifySavingsAmount']);
    Route::get('/savings/{savings}/check-maturity', [self::class, 'checkSavingsMaturity']);
    Route::get('/savings/target-funds/create', [self::class, 'viewTargetList'])->name('appuser.create-target-plan')->defaults('extras', ['icon' => 'far fa-folder']);
    Route::post('/savings/target-funds/create', [self::class, 'createNewTargetSavingsProfile'])->name('appuser.savings.target.initialise');
    Route::post('/savings/smart-savings/create', [self::class, 'initialiseSmartSavingsProfile'])->name('appuser.savings.smart.initialise');
    Route::put('/savings/smart-savings/liquidate', [self::class, 'liquidateSmartSavings'])->name('appuser.savings.smart.liquidate')->defaults('extras', ['nav_skip' => true]);
  }

  public function viewUserSavings(Request $request)
  {
    if ($request->isApi()) return $request->user()->savings_list;
    return Inertia::render('AppUser,savings/UserSavings', [
      'savings_list' => $request->user()->savings_list()->active()->with('target_type')->get(),
      'auto_save_list' => $request->user()->auto_save_settings,
      'target_types' => TargetType::all()
    ]);
  }

  public function viewTargetList()
  {
    return Inertia::render('AppUser,savings/CreateTargetPlan');
  }

  public function setAutoSaveSettings(SetAutoSaveSettingsValidation $request)
  {
    $auto_save_setting = $request->user()->auto_save_settings()->create($request->validated());

    if ($request->isApi()) {
      return response()->json(['rsp' =>  $auto_save_setting], 201);
    } else {
      return back()->withFlash(['success' => 'Success']);
    }
  }

  public function deleteAutoSaveSettings(Request $request, AutoSaveSetting $autoSaveSetting)
  {
    if ($autoSaveSetting->isForUser($request->user())) {
      $autoSaveSetting->delete();
    } else {
      $request->user()->logout();
      abort(403, 'Illegal operation');
    }

    if ($request->isApi()) {
      return response()->json(['rsp' =>  'deleted'], 201);
    } else {
      return back()->withFlash(['success' => 'Success']);
    }
  }

  public function lockMoreFunds(Request $request)
  {
    if (!$request->savings_id) {
      return generate_422_error('Invalid savings selected');
    }
    if (!$request->amount || $request->amount <= 0) {
      return generate_422_error('You need to specify an amount to add to this savings');
    }

    $savings = self::find($request->savings_id);

    if (is_null($savings)) {
      return generate_422_error('Invalid savings selected');
    }

    return PaystackTransaction::initializeTransaction($request, $request->amount, 'Fund ' . $savings->type . ' savings', route('appuser.savings.target.fund.verify', $savings->id));
  }

  public function verifyLockMoreFunds(Request $request, self $savings)
  {
    if (!($rsp = PaystackTransaction::verifyPaystackTransaction($request->trxref, $request->user()))) {
      return back()->withFlash(['error' => 'An error occured']);
    } else {

      try {

        if ($savings->type == 'smart') {
          $request->user()->fund_smart_savings($rsp['amount']);
        } else {
          $request->user()->fund_target_savings($savings, $rsp['amount']);
        }

        $request->user()->notify(new NewSavingsSuccess($rsp['amount']));

        if ($request->isApi()) {
          return response()->json(['rsp' => 'Created'], 201);
        } else {
          return back()->withFlash(['success' => 'Congrats! Funds added to savings']);
        }
      } catch (\Throwable $th) {
        if ($th->getCode() == 422) {
          return generate_422_error($th->getMessage());
        } else {
          ErrLog::notifyAdmin(auth()->user(), $th, 'Add more funds to savings failed');
        }
      };
    }
  }

  public function verifySavingsAmount(Savings $savings)
  {
    return response()->json(['verified' => $savings->is_balance_consistent()], 200);
  }

  public function checkSavingsMaturity(Request $request, self $savings)
  {
    return response()->json(['matured' => $savings->is_mature()], 200);
  }

  public function createNewTargetSavingsProfile(CreateTargetFundValidation $request)
  {
    /**
     * ! Review this to direct to paystack for payments immediately before creating
     */
    $funds = $request->user()->target_savings()->create([
      'type' => 'target',
      'target_type_id' => $request->target_type_id,
      'maturity_date' => now()->addMonths($request->duration)
    ]);
    if ($request->isApi()) {
      return response()->json(['rsp' => $funds], 201);
    } else {
      return back()->withFlash(['success' => 'Created']);
    }
  }

  public function initialiseSmartSavingsProfile(InitialiseSmartSavingsValidation $request)
  {
    $funds = $request->user()->smart_savings()->create($request->validated());

    /**
     * Notify the user that a smart savings account prifile was initialised for him. He can start saving right away
     */
    $request->user()->notify(new SmartSavingsInitialised($request->user()));

    if ($request->isApi()) return response()->json(['rsp' => $funds], 201);
    return back()->withFlash(['success' => 'Smart savings portfolio initialised successfully']);
  }

  public function liquidateSmartSavings(Request $request)
  {
    /**
     * @var Savings $smartSavings
     */
    $smartSavings = $request->user()->smart_savings;

    if (!$smartSavings->is_smart_savings()) throw ValidationException::withMessages(['err' => 'You can only liquidate your smart savings'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);

    if ($smartSavings->funded_at->gte(now()->subDays(config('app.smart_savings_minimum_liquidation_duration')))) throw ValidationException::withMessages(['err' => 'You can only liquidate your smart savings after ' . config('app.smart_savings_minimum_liquidation_duration') . ' days'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);

    $smartSavings->liquidate();

    return back()->withFlash(['success' => 'Smart savings portfolio liquidated']);
  }

  public function adminViewUserSavings(Request $request, AppUser $user)
  {
    $savings_list = (new AdminSavingsTransformer)->collectionTransformer($user->savings_list->load('target_type'), 'basic');
    // $savings_list = $user->savings_list->load('target_type');
    $auto_save_list = $user->auto_save_settings;
    // $target_types = TargetType::all();

    return Inertia::render('Admin,savings/ManageUserSavings', compact('user', 'savings_list', 'auto_save_list'));
  }

  public function lockMoreUserFunds(Request $request, AppUser $appUser)
  {
    if (!$request->savings_id) {
      return generate_422_error('Invalid savings selected');
    }
    if (!$request->amount || $request->amount <= 0) {
      return generate_422_error('You need to specify an amount to add to this savings');
    }

    $savings = self::find($request->savings_id);

    if (is_null($savings)) {
      return generate_422_error('Invalid savings selected');
    }

    try {
      if ($savings->type == 'smart') {
        $appUser->fund_smart_savings($request->amount);
      } else {
        $appUser->fund_target_savings($savings, $request->amount);
      }

      $appUser->notify(new NewSavingsSuccess($request->amount));

      if ($request->isApi()) {
        return response()->json(['rsp' => 'Created'], 201);
      } else {
        return back()->withFlash(['success' => 'Congrats! Funds added to user´s savings']);
      }
    } catch (\Throwable $th) {
      if ($th->getCode() == 422) {
        return generate_422_error($th->getMessage());
      } else {
        ErrLog::notifyAdmin(auth()->user(), $th, 'Add more funds to savings failed');
      }
    };
  }

  public function deductUserFunds(Request $request, AppUser $appUser)
  {
    if (!$request->savings_id) {
      return generate_422_error('Invalid savings selected');
    }
    if (!$request->amount || $request->amount <= 0) {
      return generate_422_error('You need to specify an amount to remove from this savings');
    }

    $savings = self::find($request->savings_id);

    if (is_null($savings)) {
      return generate_422_error('Invalid savings selected');
    }

    try {
      if ($savings->type == 'smart') {

        $appUser->defund_smart_savings($request->amount);
      } else {
        $appUser->defund_target_savings($savings, $request->amount);
      }

      if ($request->isApi()) {
        return response()->json(['rsp' => 'Deducted'], 201);
      } else {
        return back()->withFlash(['success' => 'Congrats! Funds removed user´s savings']);
      }
    } catch (\Throwable $th) {
      if ($th->getCode() == 422) {
        return generate_422_error($th->getMessage());
      } else {
        ErrLog::notifyAdmin(auth()->user(), $th, 'Deduct funds from savings failed');
      }
    };
  }

  public function getMaturedSavingsNotifications(Request $request)
  {
    $notifications = Admin::find(1)->unreadNotifications()->whereType(SavingsMaturedNotification::class)->get();

    if ($request->isApi()) return $notifications;
    return Inertia::render('Admin,AdminNotifications', [
      'notifications' => $notifications
    ]);
  }

  public function scopeSmart($query)
  {
    return $query->whereType('smart');
  }

  public function scopeTarget($query)
  {
    return $query->whereType('target');
  }

  public function scopeInvestment($query)
  {
    return $query->whereType('investment');
  }

  /**
   * Scope a query to only include only savings where the maturity_date field is in the past
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeMatured($query)
  {
    return $query->whereDate('maturity_date', '<', now());
  }

  /**
   * Scope a query to only include only savings that have not yet been withdrawn
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeNotWithdrawn($query)
  {
    return $query->whereWithdrawnAt(null);
  }

  /**
   * Scope a query to only include only savings that have been withdrawn
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeWithdrawn($query)
  {
    return $query->where('withdrawn_at', '<>', null);
  }

  /**
   * Limit query to savings that are not liquidated, has not been withdrawn and the maturity date is still in the future
   *
   * @param Builder $query
   *
   * @return Builder
   */
  public function scopeActive($query)
  {
    return $query->whereDate('maturity_date', '>=', now())->whereIsLiquidated(false)->whereWithdrawnAt(null);
  }

  public function scopeYieldsInterests($query)
  {
    return $query->whereYieldsInterests(true);
  }

  /**
   * Limit query results to savings where is_liquidated column is set to true
   *
   * @param Builder $query
   *
   * @return Builder
   */
  public function scopeLiquidated($query)
  {
    return $query->where('is_liquidated', true);
  }

  /**
   * The booting method of the model
   *
   * @return void
   */
  protected static function boot()
  {
    parent::boot();

    static::deleting(function (self $savings) {
      /**
       * Dispatch notifications
       */
      if ($savings->is_target_savings()) {
        if (now()->lt($savings->maturity_date)) {
          $savings->app_user->notify(new TargetSavingsBroken($savings));
        } else {
          $savings->app_user->notify(new TargetSavingsMatured($savings));
        }
      }

      /**
       * Clean up transactions and interests and charges
       * ? We can always provide a history preview for the user or admin as necessary
       * ! It's very important to delete their transactions so that we don´t give them interests on these deposits again
       */
      $savings->transactions()->delete();
      $savings->service_charges()->delete();
      $savings->savings_interests()->delete();
    });
  }
}
