<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\AppUser\Models\LoanRequest;

class LoanTransaction extends Model
{
	protected $fillable = [
		'amount',
		'trans_type'
	];

	protected $casts = [
		'amount' => 'double',
	];

	public function loan_request()
	{
		return $this->belongsTo(LoanRequest::class);
	}
}
