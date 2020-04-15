<?php

namespace App\Modules\AppUser\Models;

use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'amount', 'trans_type', 'savings_id', 'description'
	];
	protected $dates = ['trans_date'];

	public function savings()
	{
		return $this->belongsTo(Savings::class);
	}
}
