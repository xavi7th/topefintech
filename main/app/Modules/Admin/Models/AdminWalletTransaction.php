<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Admin\Models\AdminWalletTransaction
 *
 * @property-read \App\Modules\Admin\Models\Admin $admin
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction deposits()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction withdrawals()
 * @mixin \Eloquent
 * @property int $id
 * @property int $admin_id
 * @property float $amount
 * @property string $trans_type
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction whereTransType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminWalletTransaction whereUpdatedAt($value)
 */
class AdminWalletTransaction extends Model
{
  protected $fillable = ['amount', 'trans_type', 'description'];

  public function admin()
  {
    return $this->belongsTo(Admin::class);
  }

  public function scopeDeposits($query)
  {
    return $query->where('trans_type', 'deposit');
  }

  public function scopeWithdrawals($query)
  {
    return $query->where('trans_type', 'withdrawal');
  }
}
