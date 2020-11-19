<?php

namespace App;

use Illuminate\Support\Str;
use App\Modules\Admin\Models\Admin;
use App\Modules\Agent\Models\Agent;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Modules\Admin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Models\WithdrawalRequest;
use App\Modules\Agent\Transformers\AgentTransformer;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Modules\Admin\Transformers\AdminUserTransformer;
use App\Modules\AppUser\Transformers\AppUserTransformer;
use App\Modules\SuperAdmin\Transformers\SuperAdminUserTransformer;

/**
 * App\User
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $city
 * @property string $country
 * @property string|null $acc_num
 * @property string|null $acc_bank
 * @property string|null $acc_type
 * @property string|null $bvn
 * @property int $is_bvn_verified
 * @property int $is_bank_verified
 * @property string|null $id_card
 * @property string|null $verified_at
 * @property int $can_withdraw
 * @property int $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\WithdrawalRequest[] $processed_withdrawal_requests
 * @property-read int|null $processed_withdrawal_requests_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAccType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCanWithdraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIdCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsBankVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsBvnVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereVerifiedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $date_of_birth
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDateOfBirth($value)
 */
class User extends Authenticatable implements JWTSubject //implements MustVerifyEmail
{
  use Notifiable, SoftDeletes;

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function activities(): MorphMany
  {
    return $this->morphMany(ActivityLog::class, 'user')->latest();
  }

  public function processed_withdrawal_requests(): MorphMany
  {
    return $this->morphMany(WithdrawalRequest::class, 'processor', 'processor_type', 'processed_by')->latest();
  }

  public function get_navigation_routes(): object
  {
    if ($this->isAppUser()) {
      return get_related_routes('appuser.', ['GET']);
    } elseif ($this->isAgent()) {
      return get_related_routes('agent.', ['GET']);
    } elseif ($this->isAdmin()) {
      return get_related_routes('admin.', ['GET']);
    } elseif ($this->isSuperAdmin()) {
      return get_related_routes('superadmin.', ['GET']);
    } else {
      return get_related_routes('app.', ['GET']);
    }
  }

  public function dashboardRoute(): string
  {
    if ($this->isAppUser()) {
      return  'appuser.dashboard';
    } else if ($this->isAdmin()) {
      return 'admin.dashboard';
    } else if ($this->isSuperAdmin()) {
      return 'superadmin.dashboard';
    } else if ($this->isAgent()) {
      return 'agent.dashboard';
    } else {
      return route('home');
    }
  }

  static function hasRouteNamespace($namespace = 'app.'): bool
  {
    return Str::startsWith(Route::currentRouteName(), $namespace);
  }

  public function isSuperAdmin(): bool
  {
    return $this instanceof SuperAdmin;
  }

  public function isAdmin(): bool
  {
    return $this instanceof Admin;
  }

  public function isAppUser(): bool
  {
    return $this instanceof AppUser;
  }

  public function isAgent(): bool
  {
    return $this instanceof Agent;
  }

  public function getDetails()
  {
    if ($this->isAppUser()) {
      return (new AppUserTransformer)->detailed($this);
    } elseif ($this->isAgent()) {
      return (new AgentTransformer)->fullTransform($this);
    } elseif ($this->isAdmin()) {
      return (new SuperAdminUserTransformer)->transformForSuperAdminViewAdmins($this);
    } elseif ($this->isSuperAdmin()) {
      return (new SuperAdminUserTransformer)->transformForSuperAdminViewSuperAdmins($this);
    }
  }

  public function getType(): string
  {
    return class_basename(get_class($this));
  }

  public function setPasswordAttribute($value): void
  {
    $this->attributes['password'] = bcrypt($value);
  }

  public function toFlare(): array
  {
    // Only `id` will be sent to Flare.
    return [
      'id' => $this->id
    ];
  }

  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims()
  {
    return [];
  }
}
