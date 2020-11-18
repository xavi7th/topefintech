<?php

namespace App\Modules\SuperAdmin\Models;

use App\User;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Modules\Admin\Transformers\AdminUserTransformer;

/**
 * App\Modules\SuperAdmin\Models\SuperAdmin
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\WithdrawalRequest[] $processed_withdrawal_requests
 * @property-read int|null $processed_withdrawal_requests_count
 * @property-write mixed $password
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SuperAdmin query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $full_name
 * @property string $email
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

  static function adminRoutes()
  {
    Route::group([], function () {
      Route::get('notifications', [self::class, 'getAdminNotifications'])->name('admin.notifications')->defaults('extras', ['nav_skip' => true]);
      Route::get('admins', [self::class, 'getAdmins'])->name('admin.view_admins')->defaults('extras', ['icon' => 'fas fa-user-tie']);
      Route::post('admin/create', [self::class, 'createAdmin'])->name('admin.create');
    });
  }

  public function getAdmins(Request $request)
  {

    $admins = (new AdminUserTransformer)->collectionTransformer(self::all(), 'transformForAdminViewAdmins');
    if ($request->isApi())
      return $admins;
    return Inertia::render('Admin,ManageAdmins', compact('admins'));
  }

  public function createAdmin(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'full_name' => 'required|max:255',
      'phone' => 'required|max:20|unique:admins,email',
      'email' => 'required|email',
    ]);

    if ($validator->fails()) {
      return back()->withErrors($validator);
    }
    try {
      DB::beginTransaction();
      $admin = self::create(Arr::collapse([
        $validator->validated(),
        [
          'password' => bcrypt('agent@smartmonie')
        ]
      ]));

      DB::commit();

      if ($request->isApi())
        return response()->json(['rsp' => $admin], 201);

      return back()->withFlash(['success' => 'Admin account created. They will be required to set a password on their first login']);
    } catch (\Throwable $e) {

      ErrLog::notifySuperAdminAndFail($request->user(), $e, 'Error creating admin account');

      if ($request->isApi())
        return response()->json(['rsp' => 'error occurred'], 500);

      return back()->withFlash(['error' => 'An error occurred. Check the error logs']);
    }
  }

  public function getAdminNotifications(Request $request)
  {
    $request->user()->unreadNotifications->markAsRead();

    if ($request->isApi()) {
      return $request->user()->notifications;
    }
    return Inertia::render('Admin,AdminNotifications', [
      'notifications' => $request->user()->notifications
    ]);
  }
}
