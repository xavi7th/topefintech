<?php

namespace App\Modules\AppUser\Models;

use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;

class GOSType extends Model
{
	protected $fillable = ['name'];
	protected $table = 'gos_types';

	public function savings()
	{
		return $this->hasMany(Savings::class);
	}
}
