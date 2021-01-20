<?php

namespace App\Modules\SuperAdmin\Models;

use App\User;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Admin;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Support\Facades\Validator;
use App\Modules\SuperAdmin\Transformers\SuperAdminUserTransformer;

/**
 * App\Modules\SuperAdmin\Models\SuperAdmin
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string|null $bvn
 * @property string|null $user_passport
 * @property string|null $gender
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $dob
 * @property \Illuminate\Support\Carbon|null $verified_at
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
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin query()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereUserPassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class SuperAdmin extends User
{
  protected $table = "uyjghi";
  protected $fillable = [
    'role_id', 'full_name', 'email', 'password', 'phone', 'bvn', 'user_passport', 'gender', 'address', 'dob',
  ];
  protected $dates = ['dob', 'verified_at'];
  const DASHBOARD_ROUTE_PREFIX = 'super-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }

  static function send_notification($notification)
  {
    self::find(1)->notify($notification);
  }

  static function superAdminRoutes()
  {
    Route::group([], function () {
      Route::get('notifications', [self::class, 'getSuperAdminNotifications'])->name('superadmin.notifications')->defaults('extras', ['nav_skip' => true]);
    });
  }

  public function getSuperAdminNotifications(Request $request)
  {
    $request->user()->unreadNotifications->markAsRead();


    return Inertia::render('SuperAdmin,SuperAdminNotifications', ['notifications' => $request->user()->notifications]);
  }
}
