<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use App\Modules\AppUser\Models\LoanRequest;

class LoanSurety extends Model
{
	protected $fillable = [
		'surety_id', 'loan_request_id',
	];

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
		return $this->is_surety_accepted;
	}
	public function is_surety_rejected(): bool
	{
		return $this->is_surety_accepted === false;
	}
	public function is_surety_pending(): bool
	{
		return is_null($this->is_surety_accepted);
	}

	static function appUserRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
			Route::get('/surety-requests/requests', 'LoanSurety@getReceivedSuretyRequests');
		});
	}

	public function getReceivedSuretyRequests()
	{
		// dd(LoanRequest::find(6)->stakes_for_default());
		return response()->json(['request_details' => auth()->user()->surety_request->load(['loan_request'])], 200);
	}
}
