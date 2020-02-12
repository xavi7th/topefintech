<?php

namespace App\Modules\AppUser\Models;

use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\GOSType;
use Illuminate\Database\Eloquent\Model;

class Savings extends Model
{
	protected $fillable = ['type', 'gos_type_id', 'maturity_date', 'amount', 'savings_distribution'];
	protected $table = 'savings';

	public function user()
	{
		return $this->belongsTo(AppUser::class);
	}

	public function gos_type()
	{
		return $this->belongsTo(GOSType::class);
	}
}
