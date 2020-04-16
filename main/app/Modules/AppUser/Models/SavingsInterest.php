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

	/**
	 * Scope a query to only uncleared interests
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeUncleared($query)
	{
		return $query->where('is_cleared', false);
	}

	/**
	 * Scope a query to only uncleared interests
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $query
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeCleared($query)
	{
		return $query->where('is_cleared', true);
	}
}
