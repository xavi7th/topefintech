<?php

namespace App\Modules\AppUser\Models;

use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;

class SavingsInterest extends Model
{
	protected $fillable = ['amount', 'savings_id'];

	public function savings()
	{
		return $this->belongsTo(Savings::class);
	}
}
