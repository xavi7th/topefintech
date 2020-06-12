<?php

namespace App\Modules\AppUser\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\GOSType;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Models\ServiceCharge;
use App\Modules\AppUser\Models\Transaction;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Notifications\SmartLockBroken;
use App\Modules\AppUser\Notifications\SmartLockMature;
use App\Modules\AppUser\Notifications\GOSSavingsMatured;
use App\Modules\AppUser\Http\Requests\FundSavingsValidation;
use App\Modules\AppUser\Http\Requests\CreateGOSFundValidation;
use App\Modules\AppUser\Http\Requests\CreateLockedFundValidation;
use App\Modules\AppUser\Http\Requests\SetAutoSaveSettingsValidation;
use App\Modules\AppUser\Http\Requests\UpdateSavingsDistributionValidation;

/**
 * App\Modules\AppUser\Models\Savings
 *
 * @property int $id
 * @property int $app_user_id
 * @property string $type
 * @property int|null $gos_type_id
 * @property \Illuminate\Support\Carbon|null $maturity_date
 * @property float $current_balance
 * @property \Illuminate\Support\Carbon|null $funded_at
 * @property float $savings_distribution
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @property-read \App\Modules\AppUser\Models\GOSType|null $gos_type
 * @property-read \App\Modules\AppUser\Models\Transaction $initial_deposit_transaction
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\SavingsInterest[] $savings_interests
 * @property-read int|null $savings_interests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ServiceCharge[] $service_charges
 * @property-read int|null $service_charges_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\Transaction[] $transactions
 * @property-read int|null $transactions_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings matured()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Savings onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereCurrentBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereFundedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereGosTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereMaturityDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereSavingsDistribution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\Savings whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Savings withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\Savings withoutTrashed()
 * @mixin \Eloquent
 */
class Savings extends Model
{
  use SoftDeletes;

  protected $fillable = ['type', 'gos_type_id', 'maturity_date', 'amount', 'savings_distribution'];
  protected $table = 'savings';
  protected $dates = ['funded_at', 'maturity_date', 'interest_processed_at'];
  protected $casts = [
    'current_balance' => 'double',
    'app_user_id' => 'int',
    'gos_type_id' => 'int',
    'savings_distribution' => 'double',
  ];

  public function __construct()
  {
    Inertia::setRootView('appuser::app');
  }

  public function service_charges()
  {
    return $this->hasMany(ServiceCharge::class);
  }

  public function app_user()
  {
    return $this->belongsTo(AppUser::class);
  }

  public function belongs_to(AppUser $user): bool
  {
    return $this->app_user_id === $user->id;
  }

  public function is_core_savings(): bool
  {
    return $this->type == 'core';
  }

  public function is_smart_lock(): bool
  {
    return $this->type == 'locked';
  }

  public function is_gos_savings(): bool
  {
    return $this->type == 'gos';
  }

  public function gos_type()
  {
    return $this->belongsTo(GOSType::class)->withDefault(function ($user, $post) {
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
      ->whereDate('transactions.created_at', '<', now()->subDays(config('app.days_before_interest_starts_counting')));
  }

  public function total_deposits_sum(): float
  {
    return $this->deposit_transactions()->sum('amount');
  }

  public function total_withdrawals_sum(): float
  {
    return $this->withdrawal_transactions()->sum('amount');
  }

  public function savings_interests()
  {
    return $this->hasMany(SavingsInterest::class);
  }

  public function uncleared_savings_interests()
  {
    return $this->savings_interests()->where('is_cleared', false);
  }

  public function cleared_savings_interests()
  {
    return $this->savings_interests()->where('is_cleared', true);
  }

  public function total_accrued_interest_amount(): float
  {
    return $this->savings_interests()->sum('amount');
  }

  public function total_uncleared_interest_amount(): float
  {
    return $this->savings_interests()->uncleared()->sum('amount');
  }

  public function total_cleared_interest_amount(): float
  {
    return $this->savings_interests()->cleared()->sum('amount');
  }

  public function get_due_interest(): float
  {
    /**
     * Handle withdrawals. so you dont give interest on deposits that have been "withdrawn"
     * -- Only core savings have withdrawals
     */
    if ($this->is_core_savings()) {
      return ($this->interestable_deposit_transactions()->sum('amount') - $this->total_withdrawals_sum()) * (config('app.core_savings_interest_rate') / 100);
    } else if ($this->is_gos_savings()) {
      return $this->interestable_deposit_transactions()->sum('amount') * (config('app.gos_savings_interest_rate') / 100);
    } else if ($this->is_smart_lock()) {
      return $this->interestable_deposit_transactions()->sum('amount') * (config('app.locked_savings_interest_rate') / 100);
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
      $uncleared_interests_sum = $this->total_uncleared_interest_amount();

      if ($uncleared_interests_sum <= 0) {
        return 0;
      }

      /**
       * Add a deposit transaction for this savings with a description for interest roll over
       */
      $decsription = $decsription ?? 'Quarterly rollover of interest for ' . $this->gos_type->name . ' savings';

      $this->create_deposit_transaction($uncleared_interests_sum, $decsription);

      /**
       * Mark all the interests as cleared
       */
      $this->uncleared_savings_interests()->update(['is_cleared' => true]);

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
     * ! Fail on core savings
     * ? Core savings has no maturity date
     */
    if ($this->is_core_savings()) {
      return null;
    }

    /**
     * Check if the maturity date is up to today
     */
    return $this->maturity_date->lte(now());
  }

  public function complete_mature_savings(): bool
  {
    /**
     * Make sure this is not a core or immature locked or gos savings
     */
    if (!$this->is_mature()) {
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
     * Create a deposit transaction moving the balance of this savings to the core
     */
    $user_core_savings = $this->app_user->core_savings;

    $user_core_savings->create_deposit_transaction($this->current_balance, 'Mature ' . $this->gos_type->name . ' funds rollover');

    /**
     * Add same amount to the current balance of core savings
     */
    $user_core_savings->current_balance += $this->current_balance;
    $user_core_savings->save();

    /**
     * Delete this savings (so that it leaves the record of the user)
     * // The user can always view the record in the transaction log
     * ! It is very important to delete them so that their deposit transactions
     * ! don´t continue to receive interests even after they have matured and rolled over
     */
    $this->delete();

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

  static function appUserRoutes()
  {
    Route::group([], function () {

      Route::get('savings', [self::class, 'viewUserSavings'])->name('appuser.savings')->defaults('extras', ['icon' => 'fas fa-wallet']);

      Route::get('savings/get-distribution-details', [self::class, 'getDistributionDetails'])->name('appuser.savings.distribution')->defaults('extras', ['nav_skip' => true]);

      Route::post('/savings/fund', [self::class, 'distributeFundsToSavings'])->name('appuser.savings.fund');

      Route::post('/savings/auto-save/create', [self::class, 'setAutoSaveSettings'])->name('appuser.savings.create-autosave');

      Route::delete('/savings/auto-save/{autoSaveSetting}', [self::class, 'deleteAutoSaveSettings'])->name('appuser.savings.delete-autosave');

      Route::post('/savings/locked-funds/create', [self::class, 'createNewLockedFundsProfile'])->name('appuser.savings.locked.initialise');

      Route::post('/savings/locked-funds/add', [self::class, 'lockMoreFunds'])->name('appuser.savings.locked.fund');

      Route::get('/savings/{savings}/break', [self::class, 'breakLockedFunds']);

      Route::get('/savings/{savings}/verify', [self::class, 'verifySavingsAmount']);

      Route::get('/savings/{savings}/check-maturity', [self::class, 'checkSavingsMaturity']);

      Route::get('/savings/gos-funds/create', [self::class, 'viewGOSList'])->name('appuser.create-gos-plan')->defaults('extras', ['icon' => 'far fa-folder']);

      Route::post('/savings/gos-funds/create', [self::class, 'createNewGOSSavingsProfile'])->name('appuser.savings.gos.initialise');

      Route::get('/savings/distribution', [self::class, 'getSavingsDistributionRatio']);

      Route::put('/savings/distribution/update', [self::class, 'updateSavingsDistributionRatio'])->name('appuser.savings.distribution.update');
    });
  }


  public function viewUserSavings(Request $request)
  {
    if ($request->isApi()) {
      return $request->user()->savings_list;
    } else {
      return Inertia::render('savings/UserSavings', [
        'savings_list' => $request->user()->savings_list->load('gos_type'),
        'auto_save_list' => $request->user()->auto_save_settings,
        'gos_types' => GOSType::all()
      ]);
    }
  }

  public function viewGOSList()
  {
    return Inertia::render('savings/CreateGOSPlan');
  }

  public function getDistributionDetails(FundSavingsValidation $request)
  {

    if (!auth()->user()->has_gos_savings() && !auth()->user()->has_locked_savings()) {
      return ['core' => $request->amount];
    } else {

      $savings_distribution = [];
      $savings_distribution_percentage = 0;
      $savings_distribution_percentage += auth()->user()->core_savings->savings_distribution;
      $savings_distribution['core'] = $request->amount * (auth()->user()->core_savings->savings_distribution / 100);
      foreach (auth()->user()->gos_savings->all() as $savings) {
        $savings_distribution_percentage += $savings->savings_distribution;
        $savings_distribution[$savings->gos_type->name] = $request->amount * ($savings->savings_distribution / 100);
      }
      foreach (auth()->user()->locked_savings->all() as $savings) {
        $savings_distribution_percentage += $savings->savings_distribution;
        $savings_distribution['locked' . $savings->id] = $request->amount * ($savings->savings_distribution / 100);
      }

      if (intval($savings_distribution_percentage) !== 100) {
        return generate_422_error('Your savings distribution is not 100%. Go to savings distribution and edit');
      } else {
        return $savings_distribution;
      }
    }
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
      auth()->logout();
      abort(403, 'Illegal operation');
    }

    if ($request->isApi()) {
      return response()->json(['rsp' =>  'deleted'], 201);
    } else {
      return back()->withSuccess('Success');
    }
  }



  public function distributeFundsToSavings(FundSavingsValidation $request)
  {
    /**
     * If user has core but no gos or locked update the core
     * If user has gos or locked use distribution to spread it
     *
     * ! UPDATE CORE Update savings and create a transactions record
     * !
     */
    if (!auth()->user()->has_gos_savings() && !auth()->user()->has_locked_savings()) {
      auth()->user()->fund_core_savings($request->amount);
    } else {
      auth()->user()->distribute_savings($request->amount);
    }

    if ($request->isApi()) {
      return response()->json(['rsp' => $request->user()->savings_list], 201);
    } else {
      return back()->withSuccess('Completed! Funds have been distributed into your savings portfolio');
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

    try {
      if ($savings->type == 'core') {

        $request->user()->fund_core_savings($request->amount);
      } else {
        $request->user()->fund_locked_savings($savings, $request->amount);
      }

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

  public function breakLockedFunds(Request $request, self $savings)
  {
    // return $savings;
    /**
     * Check if this savings belongs to this user
     */
    if (!$savings->belongs_to($request->user())) {
      auth()->logout();
      $request->session()->invalidate();
      abort(403, 'Invalid transaction');
    }

    /**
     * Check if this is a locked fund
     */
    if (!$savings->is_smart_lock()) {
      return generate_422_error('This is a ' . $savings->type . ' savings. Only smart lock funds can be broken');
    }

    /**
     * Check if this savings is more than 30 days old
     */
    if ($savings->funded_at->gte(now()->subDays(30))) {
      return generate_422_error('Smart lock must be 30 days old before they can be broken');
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
    $savings->create_service_charge($service_charge, 'Amount deducted for breaking locked funds');

    /**
     * Create a deposit transaction moving the balance of this savings to the core
     * ! deduct the charge from it
     */
    $user_core_savings = $savings->app_user->core_savings;
    $balance_amount = $savings->current_balance - $service_charge;

    $user_core_savings->create_deposit_transaction($balance_amount, 'Broken smart lock funds rollover');

    /**
     * Add same amount to the current balance of core savings
     */
    $user_core_savings->current_balance += $balance_amount;
    $user_core_savings->save();

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

  public function createNewLockedFundsProfile(CreateLockedFundValidation $request)
  {
    if ($request->user()->has_locked_savings()) {
      return generate_422_error('You can only have one smart lock profile');
    }
    $funds = auth()->user()->locked_savings()->create([
      'type' => 'locked',
      'maturity_date' => now()->addMonths($request->duration)
    ]);

    if ($request->isApi()) {
      return response()->json(['rsp' => $funds], 201);
    } else {
      return back()->withSuccess('Locked Funds savings profile created');
    }
  }

  public function createNewGOSSavingsProfile(CreateGOSFundValidation $request)
  {
    $funds = auth()->user()->gos_savings()->create([
      'type' => 'gos',
      'gos_type_id' => $request->gos_type_id,
      'maturity_date' => now()->addMonths($request->duration)
    ]);
    if ($request->isApi()) {
      return response()->json(['rsp' => $funds], 201);
    } else {
      return back()->withSuccess('Created');
    }
  }

  public function getSavingsDistributionRatio(Request $request)
  {
    return response()->json($request->user()->savings_list()->get(['id', 'savings_distribution']), 200);
  }

  public function updateSavingsDistributionRatio(UpdateSavingsDistributionValidation $request)
  {
    /**
     * ? SAMPLE DATA
     * [
     *			{
     *					"id": 1,
     *					"savings_distribution": 30
     *			},
     *			{
     *					"id": 2,
     *					"savings_distribution": 15
     *			},
     *			{
     *					"id": 3,
     *					"savings_distribution": 15
     *			},
     *			{
     *					"id": 4,
     *					"savings_distribution": 25
     *			},
     *			{
     *					"id": 5,
     *					"savings_distribution": 5
     *			},
     *			{
     *					"id": 6,
     *					"savings_distribution": 10
     *			}
     *	]
     */
    $result = $request->user()->update_savings_distribution($request);

    if ($request->isApi()) {
      return response()->json($result, 201);
    }
    return back()->withSuccess('Updated');
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
      if ($savings->is_smart_lock()) {
        if (now()->lt($savings->maturity_date)) {
          $savings->app_user->notify(new SmartLockBroken($savings));
        } else {
          $savings->app_user->notify(new SmartLockMature($savings));
        }
      } elseif ($savings->is_gos_savings()) {
        $savings->app_user->notify(new GOSSavingsMatured($savings));
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
