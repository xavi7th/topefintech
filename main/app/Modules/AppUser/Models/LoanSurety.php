<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use App\Modules\AppUser\Models\LoanRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Http\Requests\SwapSuretyValidation;

/**
 * App\Modules\AppUser\Models\LoanSurety
 *
 * @property int $id
 * @property int $lender_id
 * @property int $surety_id
 * @property int $loan_request_id
 * @property int|null $is_surety_accepted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\AppUser $lender
 * @property-read \App\Modules\AppUser\Models\LoanRequest $loan_request
 * @property-read \App\Modules\AppUser\Models\AppUser $surety
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\LoanSurety onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereIsSuretyAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereLenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereLoanRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereSuretyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanSurety whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\LoanSurety withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\AppUser\Models\LoanSurety withoutTrashed()
 * @mixin \Eloquent
 */
class LoanSurety extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'surety_id', 'loan_request_id',
	];

	// protected $casts = [
	// 	'is_surety_accepted' => 'boolean',
	// ];


	public function lender()
	{
		return $this->belongsTo(AppUser::class, 'lender_id');
	}

	public function surety()
	{
		return $this->belongsTo(AppUser::class, 'surety_id');
	}

	public function loan_request()
	{
		return $this->belongsTo(LoanRequest::class);
	}

	public function is_surety_accepted(): bool
	{
		return filter_var($this->is_surety_accepted, FILTER_VALIDATE_BOOLEAN);
	}
	public function is_surety_rejected(): bool
	{
		return $this->is_surety_accepted === false;
	}
	public function is_surety_pending(): bool
	{
		return is_null($this->is_surety_accepted);
	}

	static function appUserApiRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models', 'prefix' => 'surety-requests'], function () {
			Route::get('status', 'LoanSurety@getRequestsForSureties');
			Route::get('', 'LoanSurety@getReceivedSuretyRequests');
			Route::put('', 'LoanSurety@acceptReceivedSuretyRequest');
			Route::put('/swap', 'LoanSurety@swapSuretyRequest');
		});
	}

	public function getRequestsForSureties()
	{
		return response()->json(['request_details' => auth()->user()->request_for_surety->load('surety')], 200);
	}

	public function getReceivedSuretyRequests()
	{
		return response()->json(['request_details' => optional(auth()->user()->surety_request)->load(['loan_request'])], 200);
	}

	public function acceptReceivedSuretyRequest(Request $request)
	{

		if (!$request->accepted) {
			return generate_422_error('You make make a choice');
		}
		$surety_request = Auth::apiuser()->surety_request;
		if ($surety_request) {
			$surety_request->is_surety_accepted = filter_var($request->accepted, FILTER_VALIDATE_BOOLEAN);
			$surety_request->save();
			return response()->json(['rsp' => true], 204);
		} else {
			return generate_422_error('You have no surety request');
		}
	}

	public function swapSuretyRequest(SwapSuretyValidation $request)
	{

		DB::beginTransaction();
		$surety_request = self::find($request->surety_request_id);

		/**
		 * ? Create a new surety request with this new guy
		 */
		$new_surety_request = $request->user()->create_surety_requests($request->new_surety_email, $surety_request->loan_request->id);

		/**
		 * * For simplicity just delete the previous one so that each request will always have only 2 sureties
		 */
		$surety_request->delete();

		DB::commit();

		return response()->json(['rsp' => $new_surety_request], 201);
	}
}
