<?php

namespace App\Modules\AppUser\Models;

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

class Savings extends Model
{
	use SoftDeletes;

	protected $fillable = ['type', 'gos_type_id', 'maturity_date', 'amount', 'savings_distribution'];
	protected $table = 'savings';
	protected $dates = ['funded_at', 'maturity_date'];
	protected $casts = [
		'current_balance' => 'double',
		'app_user_id' => 'int',
		'gos_type_id' => 'int',
		'savings_distribution' => 'double',
	];

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
		return $this->deposit_transactions()->whereDate('transactions.created_at', '<', now()->subDays(config('app.days_before_interest_starts_counting')));
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
			$decsription = $decsription ?? 'Quarterly rollover of interest';

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

	public function is_balance_consistent(): bool
	{
		return $this->current_balance === ($this->total_deposits_sum() - $this->total_withdrawals_sum());
	}

	static function appUserApiRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {

			Route::get('/savings', 'Savings@getListOfUserSavings');

			Route::post('/savings/fund', 'Savings@addFundsToSavings');

			Route::get('/savings/get-distribution-details', 'Savings@getDistributionDetails');

			Route::post('/savings/auto-save/create', 'Savings@setAutoSaveSettings');

			Route::post('/savings/locked-funds/create', 'Savings@createNewLockedFundsProfile');

			Route::post('/savings/locked-funds/add', 'Savings@lockMoreFunds');

			Route::get('/savings/{savings}/break', 'Savings@breakLockedFunds');

			Route::get('/savings/{savings}/verify', 'Savings@verifySavingsAmount');

			Route::post('/savings/gos-funds/create', 'Savings@createNewGOSSavingsProfile');

			Route::get('/savings/distribution', 'Savings@getSavingsDistributionRatio');

			Route::put('/savings/distribution/update', 'Savings@updateSavingsDistributionRatio');
		});
	}

	public function getListOfUserSavings()
	{
		// dd(get_class(auth()->user()));
		return auth()->user()->savings_list;
	}

	public function getDistributionDetails(FundSavingsValidation $request)
	{
		/**
		 * If user has core but no gos or locked update the core
		 * If user has gos or locked use distribution to spread it
		 *
		 * ! UPDATE CORE Update savings and create a transactions record
		 * !
		 */
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

		return response()->json(['rsp' => auth()->user()->savings_list], 201);
	}

	public function setAutoSaveSettings(SetAutoSaveSettingsValidation $request)
	{
		return response()->json(['rsp' =>  auth()->user()->auto_save_settings()->create($request->all())], 201);
	}

	public function addFundsToSavings(FundSavingsValidation $request)
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

		return response()->json(['rsp' => auth()->user()->savings_list], 201);
	}

	public function lockMoreFunds(Request $request)
	{
		if (!$request->savings_id) {
			return generate_422_error('Invalid savings selected');
		}
		if (!$request->amount) {
			return generate_422_error('You need to specify the amount to lock');
		}
		$savings = self::find($request->savings_id);

		if (is_null($savings)) {
			return generate_422_error('Invalid savings selected');
		}
		try {
			auth()->user()->fund_locked_savings($savings, $request->amount);
			return response()->json(['rsp' => 'Created'], 201);
		} catch (\Throwable $th) {
			if ($th->getCode() == 422) {
				return generate_422_error($th->getMessage());
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
			return generate_422_error('This is a ' . $savings->type . ' savings. Only locked funds can be broken');
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

	public function verifySavingsAmount(Request $request, self $savings)
	{
		return response()->json(['verified' => $savings->is_balance_consistent()], 200);
	}

	public function createNewLockedFundsProfile(CreateLockedFundValidation $request)
	{
		$funds = auth()->user()->locked_savings()->create([
			'type' => 'locked',
			'maturity_date' => now()->addMonths($request->duration)
		]);
		return response()->json(['rsp' => $funds], 201);
	}

	public function createNewGOSSavingsProfile(CreateGOSFundValidation $request)
	{
		$funds = auth()->user()->gos_savings()->create([
			'type' => 'gos',
			'gos_type_id' => $request->gos_type_id,
			'maturity_date' => now()->addMonths($request->duration)
		]);
		return response()->json(['rsp' => $funds], 201);
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
		return auth()->user()->update_savings_distribution($request);
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
			if ($savings->is_smart_lock()) {
				if (now()->lte($savings->maturity_date)) {
					$savings->app_user->notify(new SmartLockBroken($savings));
				} else {
					$savings->app_user->notify(new SmartLockMature($savings));
				}
			} elseif ($savings->is_gos_savings()) {
				$savings->app_user->notify(new GOSSavingsMatured($savings));
			}
		});
	}
}
