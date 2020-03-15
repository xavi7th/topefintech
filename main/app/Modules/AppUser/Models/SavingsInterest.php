<?php

namespace App\Modules\AppUser\Models;

use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SavingsInterest extends Model
{
	use SoftDeletes;

	protected $fillable = ['amount', 'savings_id'];

	public function savings()
	{
		return $this->belongsTo(Savings::class);
	}
}
