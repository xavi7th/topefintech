<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Admin\Models\ActivityLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Http\Requests\CreateWithdrawalRequestValidation;
use App\Modules\AppUser\Notifications\WithdrawalRequestCreatedNotification;
use App\Modules\AppUser\Notifications\DeclinedWithdrawalRequestNotification;

class WithdrawalRequest extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'app_user_id', 'payment_option', 'bitcoin_acc', 'receiver_name',
		'secret_question', 'secret_answer', 'id_type', 'country', 'acc_name',
		'acc_num', 'acc_bank', 'amount'
	];

	public function processor()
	{
		return $this->morphTo('processor', 'processor_type', 'processed_by');
	}

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

	static function adminApiRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models', 'prefix' => 'withdrawal-requests'], function () {
			Route::get('', 'WithdrawalRequest@adminGetWithdrawalRequests');
			Route::post('/{withdrawal_request}/mark-complete', 'WithdrawalRequest@approveWithdrawalRequest');
			Route::put('/{withdrawal_request}/cancel', 'WithdrawalRequest@cancelWithdrawalRequest');
		});
	}

	/**
	 * App User Routes
	 */

	public function createWithdrawalRequest(CreateWithdrawalRequestValidation $request)
	{
		// return $request->validated();
		try {
			DB::beginTransaction();
			/**
			 * Remove the amount from core savings current_balane
			 */
			$core_savings = $request->user()->core_savings;
			$core_savings->current_balance = ($core_savings->current_balance - $request->amount);
			$core_savings->save();

			/**
			 * Create a withdrawal request
			 * ! Make sure the user's surety amount is deducted if any
			 */
			$withdrawal_request = $request->user()->withdrawal_request()->create($request->validated());

			/**
			 * Notify user that his request was created
			 */
			try {
				$request->user()->notify(new WithdrawalRequestCreatedNotification);
			} catch (\Throwable $th) {
				ErrLog::notifyAdmin($request->user(), $th, 'Withdrawal request created notification failed');
			}

			DB::commit();
			return response()->json($withdrawal_request, 201);
		} catch (\Throwable $th) {
			ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Withdrawal request NOT created');
			return response()->json(['err' => 'Withdrawal request not created'], 500);
		}
	}



	/**
	 * Admin routes
	 * @return Illuminate\Http\JsonResponse
	 */
	public function adminGetWithdrawalRequests()
	{
		return response()->json(self::with('processor')->withTrashed()->get(), 200);
	}

	public function cancelWithdrawalRequest(self $withdrawal_request)
	{
		DB::beginTransaction();
		$request_details = $withdrawal_request;

		/**
		 * On withdrawal decline remember to top up the current balance back
		 */
		$request_details->app_user->core_savings->current_balance += $request_details->amount;
		$request_details->app_user->core_savings->save();

		/**
		 * Notify user that his request was declined
		 */
		try {
			$request_details->app_user->notify(new DeclinedWithdrawalRequestNotification);
		} catch (\Throwable $th) {
			ErrLog::notifyAdmin($request_details->app_user, $th, 'Declined withdrawal notification failed');
		}

		/**
		 * Delete the request;
		 */
		$request_details->delete();

		DB::commit();

		return response()->json([], 204);
	}



	protected static function boot()
	{
		parent::boot();

		static::created(function ($withdrawal_request) {
			ActivityLog::notifyAdmins(auth()->user()->email . ' requested a withdrawal request of ' . to_naira($withdrawal_request->amount));
		});

		static::deleting(function ($withdrawal_request) {
			if (!$withdrawal_request->isForceDeleting()) {
				ActivityLog::notifyAdmins(auth()->user()->email . ' declined ' . $withdrawal_request->app_user->email . '\'s withdrawal request of ' . to_naira($withdrawal_request->amount));
			}
		});

		static::retrieved(function ($withdrawal_request) {
			$withdrawal_request->load('app_user');
		});

		// static::updating(function ($withdrawal_request) {

		// dump($withdrawal_request->getOriginal());
		// dd($withdrawal_request->toArray());

		/**
		 * add an entry for the product trail that it's status changed
		 */
		// auth()->user()->product_histories()->create([
		// 	'product_id' => $withdrawal_request->id,
		// 	'product_status_id' => $withdrawal_request->product_status_id,
		// ]);
		// });
	}
}
