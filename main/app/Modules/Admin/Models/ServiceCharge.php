<?php

namespace App\Modules\Admin\Models;

use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
