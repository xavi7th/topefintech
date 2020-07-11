<?php

namespace App\Modules\AppUser\Models;

use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;

class AutoSaveSetting extends Model
{
  protected $fillable = ['amount', 'period', 'date', 'weekday', 'time', 'try_other_cards'];
  protected $casts = [
    'try_other_cards' => 'boolean',
    'amount' => 'double'
  ];
  protected $dates = ['processed_at'];

  public function app_user()
  {
    return $this->belongsTo(AppUser::class);
  }

  public function isForUser(AppUser $appUser)
  {
    return $appUser->is($this->app_user);
  }

  public function is_daily(): bool
  {
    return $this->period == 'daily';
  }

  public function is_weekly(): bool
  {
    return $this->period == 'weekly';
  }

  public function is_monthly(): bool
  {
    return $this->period == 'monthly';
  }

  public function is_quarterly(): bool
  {
    return $this->period == 'quarterly';
  }

  public function setTryOtherCardsAttribute($value)
  {
    $this->attributes['try_other_cards'] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
  }
}
