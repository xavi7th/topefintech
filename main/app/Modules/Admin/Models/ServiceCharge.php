<?php

namespace App\Modules\Admin\Models;

use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Modules\Admin\Models\ServiceCharge
 *
 * @property int $id
 * @property int $savings_id
 * @property float $amount
 * @property string $description
 * @property bool $is_processed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Modules\AppUser\Models\AppUser|null $app_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin\Models\ServiceCharge onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereIsProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereSavingsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\ServiceCharge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin\Models\ServiceCharge withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Admin\Models\ServiceCharge withoutTrashed()
 * @mixin \Eloquent
 */
class ServiceCharge extends Model
{
  use SoftDeletes;

  protected $fillable = ['amount', 'description',];
  protected $casts = [
    'is_processed' => 'boolean',
    'amount' => 'double'
  ];

  public function app_user()
  {
    return $this->hasOneThrough(AppUser::class, Savings::class);
  }
}
