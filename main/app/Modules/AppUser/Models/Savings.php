<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\GOSType;
use Illuminate\Database\Eloquent\Model;
use App\Modules\AppUser\Models\Transaction;
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Http\Requests\FundSavingsValidation;
use App\Modules\AppUser\Http\Requests\CreateGOSFundValidation;
use App\Modules\AppUser\Http\Requests\CreateLockedFundValidation;
use App\Modules\AppUser\Http\Requests\UpdateSavingsDistributionValidation;
use App\Modules\AppUser\Http\Requests\SetAutoSaveSettingsValidation;

class Savings extends Model
{
	protected $fillable = ['type', 'gos_type_id', 'maturity_date', 'amount', 'savings_distribution'];
	protected $table = 'savings';

	public function app_user()
	{
		return $this->belongsTo(AppUser::class);
	}

	public function gos_type()
	{
		return $this->belongsTo(GOSType::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

	public function deposit_transactions()
	{
		return $this->transactions()->where('trans_type', 'deposit');
	}

	public function interestable_deposit_transactions()
	{
		return $this->deposit_transactions()->whereDate('transactions.created_at', '<', now()->subDays(config('app.days_before_interest_starts_counting')));
	}

	public function savings_interets()
	{
		return $this->hasMany(SavingsInterest::class);
	}

	public function create_deposit_transaction(float $amount)
	{
		$this->transactions()->create([
			'trans_type' => 'deposit',
			'amount' => $amount,
			'savings_id' => $this->id
		]);
	}

	static function appUserRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {

			Route::get('/savings', 'Savings@getListOfUserSavings');

			Route::post('/savings/fund', 'Savings@addFundsToSavings');

			Route::get('/savings/get-distribution-details', 'Savings@getDistributionDetails');

			Route::post('/savings/auto-save/create', 'Savings@setAutoSaveSettings');

			Route::post('/savings/locked-funds/create', 'Savings@createNewLockedFundsProfile');

			Route::post('/savings/locked-funds/add', 'Savings@lockMoreFunds');

			Route::post('/savings/gos-funds/create', 'Savings@createNewGOSSavingsProfile');

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
		// dd($request->all());
		return auth()->user()->auto_save_settings()->create($request->all());
		// amount
		// period
		// date
		// weekday
		// time
		// try_other_cards
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
		$savings = Savings::find($request->savings_id);

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

	public function updateSavingsDistributionRatio(UpdateSavingsDistributionValidation $request)
	{
		/**
		 * Select the savings and update the percentage
		 * ! First check if the current distribution percentage sum + the new one is greater than 100%
		 */
		$savings_to_update = Savings::find($request->savings_id);

		return auth()->user()->update_savings_distribution($savings_to_update, $request->percentage);
	}
}
