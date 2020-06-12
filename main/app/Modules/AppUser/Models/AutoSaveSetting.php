<?php

namespace App\Modules\AppUser\Models;

use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\AppUser\Models\AutoSaveSetting
 *
 * @property int $id
 * @property int $app_user_id
 * @property float $amount
 * @property string $period
 * @property int|null $date
 * @property string|null $weekday
 * @property string|null $time
 * @property bool $try_other_cards
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereTryOtherCards($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereWeekday($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon $processed_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\AppUser\Models\AutoSaveSetting whereProcessedAt($value)
 */
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
