<?php

namespace App\Modules\AppUser\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use App\Modules\AppUser\Models\LoanSurety;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Http\Requests\CheckSuretyValidation;
use App\Modules\AppUser\Http\Requests\MakeLoanRequestValidation;

class LoanRequest extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'amount', 'expires_at', 'interest_rate', 'repayment_installation_duration', 'auto_debit',
	];

	protected $casts = [
		'expires_at' => 'timestamp'
	];

	public function app_user()
	{
		return $this->belongsTo(AppUser::class);
	}

	public function loan_sureties()
	{
		return $this->hasMany(LoanSurety::class);
	}

	static function appUserRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {

			Route::get('/loan-requests/interest-rate', 'LoanRequest@getInterestRate');
			Route::get('/loan-requests/check-eligibility', 'LoanRequest@checkLoanEligibility');
			Route::get('/loan-requests/check-surety-eligibility', 'LoanRequest@checkSuretyEligibility');
			Route::post('/loan-requests/create', 'LoanRequest@makeLoanRequest');
		});
	}

	public function getInterestRate()
	{
		return response()->json(['interest_rate' => (float)config('app.smart_loan_interest_rate')], 200);
	}

	public function checkLoanEligibility(Request $request)
	{
		if (!$request->amount) {
			return generate_422_error('Amount is required');
		} elseif (!auth()->user()->is_bvn_verified) {
			return generate_422_error('Verify your bvn to be eligible for smart loans');
		} elseif (!auth()->user()->default_debit_card()->exists()) {
			return generate_422_error('You must have one valid Debit Card set as default in your profile');
		} elseif (auth()->user()->has_pending_loan()) {
			return generate_422_error('You already have a pending loan. You are not eligible for another');
		} elseif (auth()->user()->is_loan_surety()) {
			return generate_422_error('You is currently suretying for another user. You are not eligible for another');
		}

		try {
			return response()->json(['is_eligible' => auth()->user()->is_eligible_for_loan($request->amount)], 200);
		} catch (\Throwable $th) {
			return generate_422_error('There was an error processing this request');
		}
	}

	public function checkSuretyEligibility(CheckSuretyValidation $request)
	{
		$surety = AppUser::where('email', $request->email)->first();

		if (!$surety->is_bvn_verified) {
			return generate_422_error('Surety\'s bvn is not verified to be eligible for smart loans');
		} elseif (!$surety->default_debit_card()->exists()) {
			return generate_422_error('User does not have any valid Debit Card set as default in their profile');
		} elseif ($surety->has_pending_loan()) {
			return generate_422_error('This user is not eligible for to surety for another user');
		} elseif ($surety->is_loan_surety()) {
			return generate_422_error('User is already suretying for another user. They are not eligible for another');
		}

		try {
			return response()->json(['is_eligible' => $surety->is_eligible_for_loan_surety($request->amount)], 200);
		} catch (\Throwable $th) {
			dd($th->getMessage());
			return generate_422_error('There was an error processing this request');
		}
	}

	public function makeLoanRequest(MakeLoanRequestValidation $request)
	{
		DB::beginTransaction();

		/**
		 * ! Create a loan request
		 */
		$loan_request = auth()->user()->loan_requests()->create([
			'amount' => $request->amount,
			'expires_at' => now()->addMonths(3),
			'interest_rate' => config('app.smart_loan_interest_rate'),
			'repayment_installation_duration' => $request->repayment_installation_duration,
			'auto_debit' => filter_var($request->auto_debit, FILTER_VALIDATE_BOOLEAN)

		]);
		/**
		 * ! Create a surety request
		 */

		auth()->user()->loan_surety_requests()->create(
			[
				'surety_id' => AppUser::where('email', $request->first_surety)->first()->id,
				'loan_request_id' => $loan_request->id,
			]
		);
		auth()->user()->loan_surety_requests()->create(
			[
				'surety_id' => AppUser::where('email', $request->second_surety)->first()->id,
				'loan_request_id' => $loan_request->id,
			]
		);

		DB::commit();
	}
}
