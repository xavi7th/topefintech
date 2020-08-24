<?php

namespace App\Modules\Agent\Models;

use Illuminate\Database\Eloquent\Model;

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
