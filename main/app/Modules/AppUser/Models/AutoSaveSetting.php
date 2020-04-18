<?php

namespace App\Modules\AppUser\Models;

use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;

class AutoSaveSetting extends Model
{
	protected $fillable = [
		'amount', 'period', 'date', 'weekday', 'time', 'try_other_cards',
	];
	protected $casts = [
		'try_other_cards' => 'boolean',
		'amount' => 'double'
	];


	public function app_user()
	{
		return $this->belongsTo(AppUser::class);
	}

	public function setTryOtherCardsAttribute($value)
	{
		$this->attributes['try_other_cards'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
	}
}
