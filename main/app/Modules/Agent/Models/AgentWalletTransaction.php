<?php

namespace App\Modules\Agent\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Agent\Models\AgentWalletTransaction
 *
 * @property int $id
 * @property int $agent_id
 * @property float $amount
 * @property string $trans_type
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Modules\Agent\Models\Agent $agent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction deposits()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereTransType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\AgentWalletTransaction withdrawals()
 * @mixin \Eloquent
 */
class AgentWalletTransaction extends Model
{
  protected $fillable = ['amount', 'trans_type', 'description'];

  public function agent()
  {
    return $this->belongsTo(Agent::class);
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
