<?php

namespace App\Modules\AppUser\Models;

use App\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
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
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Models\PaystackTransaction;
use App\Modules\AppUser\Notifications\NewSavingsSuccess;
use App\Modules\AppUser\Notifications\TargetSavingsBroken;
use App\Modules\AppUser\Notifications\TargetSavingsMature;
use App\Modules\AppUser\Notifications\TargetSavingsMatured;
use App\Modules\AppUser\Notifications\SmartSavingsInitialised;
use App\Modules\Admin\Notifications\SavingsMaturedNotification;
use App\Modules\AppUser\Http\Requests\CreateTargetFundValidation;
use App\Modules\AppUser\Http\Requests\SetAutoSaveSettingsValidation;
use App\Modules\AppUser\Http\Requests\InitialiseSmartSavingsValidation;

class Savings extends Model
{
  use SoftDeletes;

  protected $fillable = ['type', 'target_type_id', 'maturity_date', 'amount'];
  protected $table = 'savings';
  protected $dates = ['funded_at', 'maturity_date', 'interest_processed_at'];
  protected $casts = [
    'current_balance' => 'double',
    'app_user_id' => 'int',
    'target_type_id' => 'int',
    'is_liquidated' => 'boolean',
    'is_withdrawn' => 'boolean',
  ];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    if (User::hasRouteNamespace('appuser.')) {
      Inertia::setRootView('appuser::app');
    } elseif (User::hasRouteNamespace('admin.')) {
      Inertia::setRootView('admin::app');
    }
  }

  public function service_charges()
  {
    return $this->hasMany(ServiceCharge::class);
  }

  public function app_user()
  {
    return $this->belongsTo(AppUser::class);
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

  public function interestable_deposit_transactions()
  {
    return $this->deposit_transactions()->whereDate('interest_processed_at', '<', now())
      ->whereDate('transactions.created_at', '<', now()->subDays(config('app.days_before_interest_starts_counting')))
      ->where('yields_interests', true);
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
    return $this->app_user_id === $user->id;
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
      return ($this->interestable_deposit_transactions()->sum('amount') - $this->total_withdrawals_sum()) * (config('app.smart_savings_interest_rate') / 100);
    } else if ($this->is_target_savings()) {
      return $this->interestable_deposit_transactions()->sum('amount') * (config('app.target_savings_interest_rate') / 100);
    }
  }

  public function mark_interest_as_processed(): bool
  {
    /**
     * Mark all interestable transactions as processed
     */
    return $this->interestable_deposit_transactions()->update(['interest_processed_at' => now()]);
  }

  public function rollover_uncleared_interests(string $decsription = null): ?float
  {
    try {
      /**
       * Get sum of uncleared interests
       */
      $uncleared_interests_sum = $this->total_unprocessed_interest_amount();

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
      $this->unprocessed_savings_interests()->update(['is_cleared' => true]);

      /**
       * Add the amount to this saving's current_balance
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
     * Handle uncleared profits.
     *
     * * The uncleared profits ae added to this savings' current_balance and then marked as cleared
     * ? If return is null, then an error occured
     *
     * @return ?float
     */
    if (is_null($this->rollover_uncleared_interests())) {
      return false;
    }

    /**
     * Create a deposit transaction moving the balance of this savings to the smart
     */
    // $user_smart_savings = $this->app_user->smart_savings;

    // $user_smart_savings->create_deposit_transaction($this->current_balance, 'Mature ' . $this->target_type->name . ' funds rollover');

    /**
     * Add same amount to the current balance of smart savings
     */
    // $user_smart_savings->current_balance += $this->current_balance;
    // $user_smart_savings->save();

    /**
     * Delete this savings (so that it leaves the record of the user)
     * // The user can always view the record in the transaction log
     * ! It is very important to delete them so that their deposit transactions
     * ! don´t continue to receive interests even after they have matured and rolled over
     */
    // $this->delete();

    DB::commit();

    return true;
  }

  public function create_deposit_transaction(float $amount, string $desc)
  {
    $this->transactions()->create([
      'trans_type' => 'deposit',
      'amount' => $amount,
      'description' => $desc
    ]);
  }

  public function create_withdrawal_transaction(float $amount, string $desc)
  {
    $this->transactions()->create([
      'trans_type' => 'withdrawal',
      'amount' => $amount,
      'description' => $desc
    ]);
  }

  public function create_service_charge(float $amount, string $desc): void
  {
    $this->service_charges()->create([
      'amount' => $amount,
      'description' => $desc
    ]);
  }

  public function create_interest_record(float $amount): void
  {
    $this->savings_interests()->create([
      'amount' => $amount
    ]);
  }

  public function is_balance_consistent(): bool
  {
    return $this->current_balance === ($this->total_deposits_sum() - $this->total_withdrawals_sum());
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
     */
    $accruedInterests = $this->savings_interests()->unlocked()->unprocessed()->sum('amount');
    $this->current_balance += $accruedInterests;

    /**
     * Create a deposit transaction of this rollover for user's records
     */
    $this->transactions()->create([
      'type' => 'deposit',
      'amount' => $accruedInterests,
      'yields_interests' => false,
      'description' => 'Rollover of accumulated interests into smart savings balance'
    ]);

    $this->is_liquidated = true;
    $this->save();

    DB::commit();
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

  public function getTotalDurationAttribute()
  {
    return optional($this->maturity_date)->diffInDays($this->funded_at);
  }

  public function getElapsedDurationAttribute()
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

    Route::get('/savings/{savings}/break', [self::class, 'breakTargetFunds']);

    Route::get('/savings/{savings}/verify', [self::class, 'verifySavingsAmount']);

    Route::get('/savings/{savings}/check-maturity', [self::class, 'checkSavingsMaturity']);

    Route::get('/savings/target-funds/create', [self::class, 'viewTargetList'])->name('appuser.create-target-plan')->defaults('extras', ['icon' => 'far fa-folder']);

    Route::post('/savings/target-funds/create', [self::class, 'createNewTargetSavingsProfile'])->name('appuser.savings.target.initialise');

    Route::post('/savings/smart-savings/create', [self::class, 'initialiseSmartSavingsProfile'])->name('appuser.savings.smart.initialise');

    Route::put('/savings/smart-savings/liquidate', [self::class, 'liquidateSmartSavings'])->name('appuser.savings.smart.liquidate')->defaults('extras', ['nav_skip' => true]);
  }

  public function viewUserSavings(Request $request)
  {
    if ($request->isApi()) {
      return $request->user()->savings_list;
    } else {
      return Inertia::render('AppUser,savings/UserSavings', [
        'savings_list' => $request->user()->savings_list->load('target_type'),
        'auto_save_list' => $request->user()->auto_save_settings,
        'target_types' => TargetType::all()
      ]);
    }
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
      return back()->withSuccess('Success');
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
      return back()->withSuccess('Success');
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
      return back()->withError('An error occured');
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
          return back()->withSuccess('Congrats! Funds added to savings');
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

  public function breakTargetFunds(Request $request, self $savings)
  {
    // return $savings;
    /**
     * Check if this savings belongs to this user
     */
    if (!$savings->belongs_to($request->user())) {
      $request->user()->logout();
      $request->session()->invalidate();
      abort(403, 'Invalid transaction');
    }

    /**
     * Check if this is a target fund
     */
    if (!$savings->is_target_savings()) {
      return generate_422_error('This is a ' . $savings->type . ' savings. Only target savings funds can be broken');
    }

    /**
     * Check if this savings is more than 30 days old
     */
    if ($savings->funded_at->gte(now()->subDays(30))) {
      return generate_422_error('target savings must be 30 days old before they can be broken');
    }

    /**
     * Get deductible percentage of total accrued funds
     */
    $service_charge = $savings->total_accrued_interest_amount() * (config('app.lock_break_percentage_charge') / 100);

    DB::beginTransaction();
    /**
     * Handle uncleared profits
     */

    if (is_null($savings->rollover_uncleared_interests($desc = 'Break lock interests rollover'))) {
      return generate_422_error('There was an error breaking your lock. Try again');
    }

    /**
     * Create a service charge transaction for this savings for the lock break charge
     */
    $savings->create_service_charge($service_charge, 'Amount deducted for breaking target funds');

    /**
     * Create a deposit transaction moving the balance of this savings to the smart
     * ! deduct the charge from it
     */
    $user_smart_savings = $savings->app_user->smart_savings;
    $balance_amount = $savings->current_balance - $service_charge;

    $user_smart_savings->create_deposit_transaction($balance_amount, 'Broken target savings funds rollover');

    /**
     * Add same amount to the current balance of smart savings
     */
    $user_smart_savings->current_balance += $balance_amount;
    $user_smart_savings->save();

    /**
     * Delete this savings (so that it leaves the record of the user)
     */
    $savings->delete();

    DB::commit();

    return response()->json(['status' => true], 200);
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
      return back()->withSuccess('Created');
    }
  }

  public function initialiseSmartSavingsProfile(InitialiseSmartSavingsValidation $request)
  {
    $funds = $request->user()->smart_savings()->create([
      'type' => 'smart',
      'maturity_date' => now()->addMonths($request->duration)
    ]);

    /**
     * Notify the user that a smart savings account prifile was initialised for him. He can start saving right away
     */
    $request->user()->notify(new SmartSavingsInitialised($request->user()));

    if ($request->isApi()) {
      return response()->json(['rsp' => $funds], 201);
    } else {
      return back()->withSuccess('Smart savings portfolio initialised successfully');
    }
  }

  public function liquidateSmartSavings(Request $request)
  {
    $smartSavings = $request->user()->smart_savings;

    if ($smartSavings->is_target_savings()) {
      abort(422, 'You can only liquidate your smart savings');
    }

    if ($smartSavings->funded_at->gte(now()->subDays(config('app.smart_savings_minimum_liquidation_duration')))) {
      abort(422, 'You can only liquidate your smart savings after ' . config('app.smart_savings_minimum_liquidation_duration') . ' days');
    }

    $smartSavings->liquidate();
  }

  public function adminViewUserSavings(Request $request, AppUser $user)
  {
    $savings_list = $user->savings_list->load('target_type');
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
        return back()->withSuccess('Congrats! Funds added to user´s savings');
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
        return back()->withSuccess('Congrats! Funds removed user´s savings');
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

    if ($request->isApi()) {
      return $notifications;
    }
    return Inertia::render('Admin,AdminNotifications', [
      'notifications' => $notifications
    ]);
  }

  /**
   * Scope a query to only include matured savings
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeMatured($query)
  {
    return $query->whereDate('maturity_date', '<=', now());
  }

  public function scopeActive($query)
  {
    return $query->whereDate('maturity_date', '>=', now())->whereIsLiquidated(false)->whereIsWithdrawn(false);
  }

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

    static::deleting(function ($savings) {
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
