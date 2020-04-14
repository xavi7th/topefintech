<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Http\Requests\CreateWithdrawalRequestValidation;

class WithdrawalRequest extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'app_user_id', 'payment_option', 'bitcoin_acc', 'receiver_name',
		'secret_question', 'secret_answer', 'id_type', 'country', 'acc_name',
		'acc_num', 'acc_bank', 'amount'
	];

	public function app_user()
	{
		return $this->belongsTo(AppUser::class);
	}

	static function appUserApiRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
			Route::get('/withdrawal-requests', 'WithdrawalRequest@getWithdrawalRequests');
			Route::post('/withdrawal-request/create', 'WithdrawalRequest@createWithdrawalRequest');
		});
	}

	public function createWithdrawalRequest(CreateWithdrawalRequestValidation $request)
	{
		// return $request->validated();
		try {
			DB::beginTransaction();
			/**
			 * Remove the amount from core savings current_balane
			 */
			$core_savings = $request->user()->core_savings;
			$core_savings->current_balance = $core_savings->current_balance - $request->amount;
			$core_savings->save();

			/**
			 * Create a withdrawal request
			 * ! Make sure the user's surety amount is deducted if any
			 */
			$withdrawal_request = $request->user()->withdrawal_request()->create([
				'amount' => ($request->user()->total_withdrawable_amount() - $request->user()->loan_surety_amount())
			]);

			DB::commit();
			return response()->json($withdrawal_request, 201);
		} catch (\Throwable $th) {
			ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Withdrawal request NOT created');
			return response()->json(['err' => 'Withdrawal request not created'], 500);
		}
	}
}
