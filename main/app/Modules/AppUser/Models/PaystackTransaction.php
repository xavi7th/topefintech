<?php

namespace App\Modules\AppUser\Models;

use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\AppUser\Models\PaystackTransaction
 *
 * @property int $id
 * @property int $app_user_id
 * @property string $transaction_reference
 * @property string $paystack_response
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction wherePaystackResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereTransactionReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\PaystackTransaction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaystackTransaction extends Model
{
  protected $fillable = ['amount', 'description', 'transaction_reference'];

  public function app_user()
  {
    return $this->belongsTo(AppUser::class);
  }

  static function getByRef(string $trxrf)
  {
    return self::where('transaction_reference', $trxrf)->first();
  }
}
