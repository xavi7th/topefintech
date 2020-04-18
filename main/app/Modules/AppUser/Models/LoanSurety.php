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
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
			Route::get('/surety-requests', 'LoanSurety@getReceivedSuretyRequests');
			Route::put('/surety-requests', 'LoanSurety@acceptReceivedSuretyRequest');
			Route::put('/surety-requests/swap', 'LoanSurety@swapSuretyRequest');
		});
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
		$new_surety_request = auth()->user()->loan_surety_requests()->create(
			[
				'surety_id' => AppUser::where('email', $request->new_surety_email)->first()->id,
				'loan_request_id' => $surety_request->loan_request->id,
			]
		);

		/**
		 * * For simplicity just delete the previous one so that each request will always have only 2 sureties
		 */
		$surety_request->delete();

		DB::commit();

		return response()->json(['rsp' => $new_surety_request], 201);
	}
}
