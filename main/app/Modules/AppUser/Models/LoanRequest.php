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
use App\Modules\AppUser\Models\LoanTransaction;
use App\Modules\AppUser\Http\Requests\CheckSuretyValidation;
use App\Modules\AppUser\Http\Requests\LoanRepaymentValidation;
use App\Modules\AppUser\Http\Requests\MakeLoanRequestValidation;

class LoanRequest extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'amount', 'expires_at', 'interest_rate', 'repayment_installation_duration', 'auto_debit', 'loan_ref'
	];

	protected $dates = [
		'expires_at'
	];

	protected $casts = [
		'auto_debit' => 'boolean'
	];

	protected $appends = ['is_defaulted', 'stakes_for_default', 'grace_period_expiry', 'installments', 'total_refunded', 'auto_refund_settings'];

	public function app_user()
	{
		return $this->belongsTo(AppUser::class);
	}

	public function loan_transactions()
	{
		return $this->hasMany(LoanTransaction::class);
	}

	public function loan_sureties()
	{
		return $this->hasMany(LoanSurety::class);
	}

	public function is_surety_approved(): bool
	{
		return $this->loan_sureties()->where('is_surety_accepted', true)->count() === 2;
	}

	public function total_repayment_amount(): float
	{
		return $this->loan_transactions()->where('trans_type', 'repayment')->sum('amount');
	}

	public function loan_statistics(): object
	{
		return (object)[
			'total_paid' => $total_paid = $this->total_repayment_amount(),
			'balance_left' => $this->amount - $total_paid
		];
	}

	public function getStakesForDefaultAttribute()
	{
		$lender_stake = ceil(optional($this->app_user)->total_balance());
		if ($lender_stake > $this->amount) {
			return [
				'lender_stake' => ceil($this->amount - $this->total_refunded),
				'first_surety_stake' => 0,
				'second_surety_stake' => 0,
			];
		} else {
			$loan_balance = ceil(($this->amount - $this->total_refunded) - $lender_stake);
			$first_surety_stake = $second_surety_stake = ceil($loan_balance / 2);
			return [
				'lender_stake' => $lender_stake,
				'first_surety_stake' => $first_surety_stake,
				'second_surety_stake' => $second_surety_stake,
			];
		}
	}

	public function getGracePeriodExpiryAttribute()
	{
		return optional($this->expires_at)->addDays(config('app.smart_loan_grace_period'));
	}

	public function getIsDefaultedAttribute(): bool
	{
		return now()->gte($this->grace_period_expiry);
	}

	public function getInstallmentsAttribute(): array
	{
		if ($this->repayment_installation_duration == 'weekly') {
			$duration_in_weeks = $this->expires_at->diffInWeeks($this->created_at);
			$installmental_amount = ceil($this->amount / $duration_in_weeks);
			return [
				'amount' => (float)$installmental_amount,
				'description' => to_naira($installmental_amount) . '/week',
				'duration' => $duration_in_weeks . ' weeks'
			];
		} elseif ($this->repayment_installation_duration == 'monthly') {
			$duration_in_months = $this->expires_at->diffInMonths($this->created_at);
			$installmental_amount = ceil($this->amount / $duration_in_months);
			return [
				'amount' => (float)$installmental_amount,
				'description' => to_naira($installmental_amount) . '/month',
				'duration' => $duration_in_months . ' months'
			];
		} else {
			return [
				'amount' => 'Invalid repayment installation duration selected',
				'description' => 'Invalid repayment installation duration selected',
				'duration' => 'Invalid repayment installation duration selected'
			];
		}
	}

	public function getTotalRefundedAttribute()
	{
		return $this->total_repayment_amount();
	}

	public function getAutoRefundSettingsAttribute()
	{
		if ($this->auto_debit) {
			if ($this->repayment_installation_duration == 'weekly') {
				return config('app.smart_loan_weekly_auto_debit_day') . ' of every week';
			} elseif ($this->repayment_installation_duration == 'monthly') {
				return str_ordinal(config('app.smart_loan_monthly_auto_debit_day')) . ' of every month';
			}
		}
	}

	static function appUserRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {

			Route::get('/loan-requests/interest-rate', 'LoanRequest@getInterestRate');
			Route::get('/loan-requests/check-eligibility', 'LoanRequest@checkLoanEligibility');
			Route::get('/loan-requests/check-surety-eligibility', 'LoanRequest@checkSuretyEligibility');
			Route::post('/loan-requests/create', 'LoanRequest@makeLoanRequest');
			Route::get('/loan-requests', 'LoanRequest@getLoanRequests');
			Route::get('/loan-requests/{loan_request}/transactions', 'LoanRequest@getLoanRequestTransactions');
			Route::post('/loan-requests/{loan_request}/make-repayment', 'LoanRequest@repayLoan');
		});
	}

	static function adminRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
			Route::get('/loan-requests', 'LoanRequest@adminGetLoanRequests');
			Route::get('/loan-requests/{loan_request}/transactions', 'LoanRequest@adminGetLoanRequestTransactions');
			Route::put('/loan-request/{loan_request}/approve', 'LoanRequest@approveLoanRequest');
			Route::put('/loan-request/{loan_request}/mark-disbursed', 'LoanRequest@markLoanAsDisbursed');
		});
	}


	public function getInterestRate()
	{
		return response()->json(['interest_rate' => (float)config('app.smart_loan_interest_rate')], 200);
	}

	public function getLoanRequests()
	{
		return response()->json(auth()->user()->loan_requests->load(['loan_sureties.surety']), 200);
	}

	public function getLoanRequestTransactions(LoanRequest $loan_request)
	{
		return response()->json(collect($loan_request->load('loan_transactions'))->merge($loan_request->loan_statistics()), 200);
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
			'auto_debit' => filter_var($request->auto_debit, FILTER_VALIDATE_BOOLEAN),
			'loan_ref' => unique_random('loan_requests', 'loan_ref', null, 12)
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

	public function repayLoan(LoanRepaymentValidation $request, LoanRequest $loan_request)
	{
		$loan_request->loan_transactions()->create([
			'amount' => $request->amount,
			'trans_type' => 'repayment'
		]);

		return response()->json(['rsp' => true], 201);
	}

	/**
	 * ! Admin Routes
	 */

	public function adminGetLoanRequests()
	{
		return LoanRequest::with('loan_sureties.surety')->get();
	}

	public function approveLoanRequest(self $loan_request)
	{
		if ($loan_request->is_approved) {
			return generate_422_error('Already approved');
		}
		if ($loan_request->is_surety_approved()) {
			$loan_request->is_approved = true;
			$loan_request->approved_at = now();
			$loan_request->approved_by = auth()->id();
			$loan_request->save();

			return response()->json(['rsp' => true], 204);
		} else {
			return generate_422_error('Both sureties have not yet approved the request');
		}
	}

	public function markLoanAsDisbursed(self $loan_request)
	{

		if (!$loan_request->is_approved) {
			return generate_422_error('Mark loan as approved first');
		}


		if ($loan_request->is_disbursed) {
			return generate_422_error('Loan already disbursed');
		}
		DB::beginTransaction();
		//create a transaction for the loan for amount minus interest
		$loan_request->loan_transactions()->create([
			'amount' => $loan_request->amount - ($loan_request->amount * (config('app.smart_loan_interest_rate') / 100)),
			'trans_type' => 'loan'
		]);

		$loan_request->is_disbursed = true;
		$loan_request->save();
		DB::commit();

		return response()->json(['rsp' => true], 403);
	}

	public function adminGetLoanRequestTransactions(LoanRequest $loan_request)
	{
		return response()->json(collect($loan_request->load('loan_transactions'))->merge($loan_request->loan_statistics()), 200);
	}
}
