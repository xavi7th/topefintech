<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use App\Modules\AppUser\Http\Requests\AddNewDebitCardValidation;
use Illuminate\Database\Eloquent\SoftDeletes;

class DebitCard extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'pan', 'month', 'year', 'cvv',
	];

	protected $hidden = ['cvv_hash', 'pan_hash'];

	public function app_user()
	{
		return $this->belongsTo(AppUser::class);
	}

	public function belongs_to(AppUser $user): bool
	{
		return $this->app_user_id === $user->id;
	}

	public function is_default_card(): bool
	{
		return $this->is_default;
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


	static function appUserApiRoutes()
	{
		Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {

			Route::get('/debit-cards', 'DebitCard@getDebitCards');

			Route::post('/debit-card/create', 'DebitCard@addNewDebitCard');

			Route::put('/debit-card/default', 'DebitCard@setDefaultDebitCard');

			Route::delete('/debit-card/{debit_card}', 'DebitCard@deleteDebitCard');
		});
	}

	public function getDebitCards()
	{
		return auth()->user()->debit_cards;
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

	public function deleteDebitCard(Request $request, self $debit_card)
	{
		if ($debit_card->belongs_to(auth()->user())) {
			/**
			 * Check if this is his default card
			 */
			if ($debit_card->is_default_card()) {
				return generate_422_error('You cannot delete your default card.');
			}

			/**
			 * Check if he has autosave
			 */
			if ($request->user()->has_auto_save()) {
				return generate_422_error('You cannot delete your card when you have activated autosave. Contact support if you really need to remove your card.');
			}

			/**
			 * Check if he has pending loan
			 */
			if ($request->user()->has_pending_loan()) {
				return generate_422_error('You cannot delete debit cards while you have a pending loan');
			}

			/**
			 * then delete the card soft delete
			 */

			$debit_card->delete();

			return response()->json([], 204);
		} else {
			abort(403, 'invalid operation');
		}
	}
}
