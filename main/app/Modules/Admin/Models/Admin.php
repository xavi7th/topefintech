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

class Admin extends User
{
  protected $fillable = [
    'role_id', 'full_name', 'email', 'password', 'phone', 'bvn', 'user_passport', 'gender', 'address', 'dob',
  ];

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

      ErrLog::notifyAdminAndFail($request->user(), $e, 'Error creating admin account');

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
