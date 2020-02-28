<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use App\Modules\AppUser\Http\Requests\AddNewDebitCardValidation;

class DebitCard extends Model
{
	protected $fillable = [
		'pan', 'month', 'year', 'cvv',
	];

	protected $hidden = ['cvv_hash', 'pan_hash'];

	public function app_user()
	{
		return $this->belongsTo(AppUser::class);
	}


	public function setPanAttribute($value)
	{
		$this->attributes['pan'] = encrypt($value);
		$this->attributes['pan_hash'] = bcrypt($value);
	}

	public function getPanAttribute($value)
	{
		return 'ending in ' . substr(decrypt($this->attributes['pan']), -4);
	}

	public function setCvvAttribute($value)
	{
		$this->attributes['cvv'] = encrypt($value);
		$this->attributes['cvv_hash'] = bcrypt($value);
	}

	public function getCvvAttribute()
	{
		return '****'; //decrypt($this->attributes['cvv']);
	}


	static function appUserRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {

			Route::post('/debit-card/create', 'DebitCard@addNewDebitCard');

			Route::put('/debit-card/default', 'DebitCard@setDefaultDebitCard');
		});
	}

	public function addNewDebitCard(AddNewDebitCardValidation $request)
	{
		return response()->json(['rsp' => auth()->user()->debit_cards()->create($request->all())], 201);
	}

	public function setDefaultDebitCard()
	{
		$debit_card = DebitCard::findOrFail(request('debit_card_id'));

		auth()->user()->debit_cards()->update(['is_default' => false]);

		$debit_card->is_default = true;
		$debit_card->save();

		return response()->json(['rsp' => true], 204);
	}
}
