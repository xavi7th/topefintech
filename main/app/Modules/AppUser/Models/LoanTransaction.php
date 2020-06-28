<?php

namespace App\Modules\AppUser\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Modules\AppUser\Models\LoanRequest;

/**
 * App\Modules\AppUser\Models\LoanTransaction
 *
 * @property int $id
 * @property int $loan_request_id
 * @property float $amount
 * @property string $trans_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\LoanRequest $loan_request
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereLoanRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereTransType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\LoanTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

  public function getDescriptionAttribute()
  {
    return $this->trans_type == 'loan' ?  'Deposit transaction on ' . to_naira($this->loan_request->amount) . ' loan'
      : Str::title($this->loan_request->repayment_installation_duration) . ' loan repayment on ' . to_naira($this->loan_request->amount) . ' loan';
  }
}
