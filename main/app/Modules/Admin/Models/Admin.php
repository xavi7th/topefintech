<?php

namespace App\Modules\Admin\Models;

use App\User;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Modules\Admin\Transformers\AdminUserTransformer;

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

  protected $dates = ['dob', 'verified_at'];
  const DASHBOARD_ROUTE_PREFIX = 'admin-panel';

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    Inertia::setRootView('admin::app');
  }

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
      return back()
        ->withErrors($validator)
        ->withError('There are errors in your form');
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

      return back()->withSuccess('Admin account created. They will be required to set a password on their first login');
    } catch (\Throwable $e) {

      ErrLog::notifyAdminAndFail($request->user(), $e, 'Error creating admin account');

      if ($request->isApi())
        return response()->json(['rsp' => 'error occurred'], 500);

      return back()->withError('An error occurred. Check the error logs');
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
