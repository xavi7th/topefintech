<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\GOSType;
use Illuminate\Database\Eloquent\Model;
use App\Modules\AppUser\Http\Requests\FundSavingsValidation;
use App\Modules\AppUser\Http\Requests\CreateGOSFundValidation;
use App\Modules\AppUser\Http\Requests\CreateLockedFundValidation;
use App\Modules\AppUser\Http\Requests\UpdateSavingsDistributionValidation;

class Savings extends Model
{
	protected $fillable = ['type', 'gos_type_id', 'maturity_date', 'amount', 'savings_distribution'];
	protected $table = 'savings';

	public function user()
	{
		return $this->belongsTo(AppUser::class);
	}

	public function gos_type()
	{
		return $this->belongsTo(GOSType::class);
	}

	static function appUserRoutes()
	{

		Route::post('/savings/fund', function (FundSavingsValidation $request) {

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
		});

		Route::post('/savings/locked-funds/create', function (CreateLockedFundValidation $request) {
			$funds = auth()->user()->locked_savings()->create([
				'type' => 'locked',
				'maturity_date' => now()->addMonths($request->duration)
			]);
			return response()->json(['rsp' => $funds], 201);
		});

		Route::post('/savings/gos-funds/create', function (CreateGOSFundValidation $request) {
			$funds = auth()->user()->gos_savings()->create([
				'type' => 'gos',
				'gos_type_id' => $request->gos_type_id,
				'maturity_date' => now()->addMonths($request->duration)
			]);
			return response()->json(['rsp' => $funds], 201);
		});

		Route::put('/savings/distribution/update', function (UpdateSavingsDistributionValidation $request) {
			/**
			 * Select the savings and update the percentage
			 * ! First check if the current distribution percentage sum + the new one is greater than 100%
			 */
			$savings_to_update = Savings::find($request->savings_id);

			return auth()->user()->update_savings_distribution($savings_to_update, $request->percentage);
		});

		Route::get('/savings', function () {
			// dd(get_class(auth()->user()));
			return auth()->user()->savings_list;
		});
	}
}
