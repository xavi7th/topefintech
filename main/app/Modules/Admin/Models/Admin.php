<?php

namespace App\Modules\Admin\Models;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\BasicSite\Models\Message;
use App\Modules\AppUser\Models\Transaction;
use App\Modules\Admin\Transformers\AdminUserTransformer;
use App\Modules\Admin\Notifications\SavingsMaturedNotification;

/**
 * App\Modules\Admin\Models\Admin
 *
 * @property int $id
 * @property int|null $role_id
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereUserPassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Admin\Models\Admin whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class Admin extends User
{
  protected $fillable = [
    'role_id', 'full_name', 'email', 'password', 'phone', 'bvn', 'user_passport', 'gender', 'address', 'dob',
  ];
  protected $table = "admins";
  protected $dates = ['dob', 'verified_at'];
  const DASHBOARD_ROUTE_PREFIX = 'admin-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }

  static function send_notification($notification)
  {
    self::find(1)->notify($notification);
  }

  static function adminApiRoutes()
  {
    Route::group(['namespace' => '\App\Modules\Admin\Models'], function () {


      Route::get('dashboard/statistics', 'Admin@getDashboardStatistics');

      Route::get('/savings', 'Admin@getListOfUserSavings');

      Route::get('admins', 'Admin@getAdmins');

      Route::post('admin/create', 'Admin@createAdmin');

      Route::get('admin/notifications/matured-savings', 'Admin@getMaturedSavingsNotifications');
    });
  }

  public function getDashboardStatistics()
  {
    return [
      'total_users' => AppUser::count(),
      'total_transactions' => Transaction::where('trans_type', '<>', 'withdrawal')->count(),
      'total_withdrawals' => Transaction::where('trans_type', 'withdrawal')->count(),
      'total_messages' => Message::count(),
    ];
  }

  public function getAdmins()
  {
    return (new AdminUserTransformer)->collectionTransformer(self::all(), 'transformForAdminViewAdmins');
  }

  public function createAdmin()
  {

    try {
      DB::beginTransaction();
      $admin = self::create(Arr::collapse([
        request()->all(),
        [
          'password' => bcrypt('amju@admin'),
          'role_id' => self::getAdminId()
        ]
      ]));
      DB::commit();
      return response()->json(['rsp' => $admin], 201);
    } catch (\Throwable $e) {
      if (app()->environment() == 'local') {
        return response()->json(['error' => $e->getMessage()], 500);
      }
      return response()->json(['rsp' => 'error occurred'], 500);
    }
  }

  public function getMaturedSavingsNotifications()
  {
    return  self::find(1)->unreadNotifications()->whereType(SavingsMaturedNotification::class)->get();
  }
}
