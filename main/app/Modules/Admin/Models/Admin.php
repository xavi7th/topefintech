<?php

namespace App\Modules\Admin\Models;

use App\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\Savings;
use Illuminate\Support\Facades\Validator;
use App\Modules\Admin\Models\AdminWalletTransaction;
use App\Modules\AppUser\Notifications\NewSavingsSuccess;

/**
 * App\Modules\Admin\Models\Admin
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
 * @property-read float $wallet_balance
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\AppUser\Models\WithdrawalRequest[] $processed_withdrawal_requests
 * @property-read int|null $processed_withdrawal_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|AdminWalletTransaction[] $wallet_transactions
 * @property-read int|null $wallet_transactions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUserPassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereVerifiedAt($value)
 * @mixin \Eloquent
 */
class Admin extends User
{
  protected $table = "ythfg";
  protected $fillable = [
    'role_id', 'full_name', 'email', 'password', 'phone', 'bvn', 'user_passport', 'gender', 'address', 'dob',
  ];
  protected $dates = ['dob', 'verified_at'];
  protected $appends = ['wallet_balance'];
  const DASHBOARD_ROUTE_PREFIX = 'admin-panel';

  public function wallet_transactions()
  {
    return $this->hasMany(AdminWalletTransaction::class);
  }

  public function is_verified()
  {
    return $this->verified_at !== null;
  }

  public function getWalletBalanceAttribute(): float
  {
    return $this->wallet_transactions()->deposits()->sum('amount') - $this->wallet_transactions()->withdrawals()->sum('amount');
  }


  static function send_notification($notification)
  {
    self::find(1)->notify($notification);
  }

  static function adminRoutes()
  {
    Route::group([], function () {
      Route::post('{appUser:phone}/savings/target-funds/add', [self::class, 'fundManagedUser'])->name('admin.user_savings.target.fund');
      Route::get('notifications', [self::class, 'getAdminNotifications'])->name('admin.notifications')->defaults('extras', ['nav_skip' => true]);
    });
  }

  static function superAdminRoutes()
  {
    Route::name('superadmin.')->prefix('admins')->group(function () {
      Route::post('{admin}/fund', [self::class, 'fundAdmin'])->name('fund_admin');
    });
  }


  public function fundManagedUser(Request $request, AppUser $appUser)
  {
    if (!$request->savings_id) {
      return generate_422_error('Invalid savings selected');
    }
    if (!$request->amount || $request->amount <= 0) {
      return generate_422_error('You need to specify an amount to add to this savings');
    }

    if ($request->amount > $request->user()->wallet_balance) {
      return generate_422_error('The specified amount is greater than your wallet balance');
    }

    $savings = Savings::find($request->savings_id);

    if (is_null($savings)) {
      return generate_422_error('Invalid savings selected');
    }

    try {
      DB::beginTransaction();

      $request->user()->wallet_transactions()->create([
        'trans_type' => 'withdrawal',
        'amount' => $request->amount,
        'description' => 'Admin account funding for ' . $appUser->full_name
      ]);

      if ($savings->type == 'smart') {
        $appUser->fund_smart_savings($request->amount);
      } else {
        $appUser->fund_target_savings($savings, $request->amount);
      }

      try {
        $appUser->notify(new NewSavingsSuccess($request->amount));
      } catch (\Throwable $th) {
        ErrLog::notifySuperAdmin($request->user(), $th, 'Failed to notify user of account funding');
      }

      DB::commit();

      if ($request->isApi()) return response()->json(['rsp' => 'Created'], 201);
      return back()->withFlash(['success' => 'Congrats! Funds added to user´s savings']);
    } catch (\Throwable $th) {
      if ($th->getCode() == 422) {
        return generate_422_error($th->getMessage());
      } else {
        ErrLog::notifySuperAdminAndFail($request->user(), $th, 'Fund user savings failed');
        return back()->withFlash(['error' => 'Fund user savings failed']);
      }
    };
  }


  public function fundAdmin(Request $request, self $admin)
  {
    $validator = Validator::make($request->all(), [
      'amount' => 'required|numeric',
    ]);

    if ($validator->fails()) {
      return back()
        ->withErrors($validator);
    }

    try {
      $admin->wallet_transactions()->create([
        'amount' => $request->amount,
        'trans_type' => 'deposit',
        'description' => 'Admin Wallet top-up',
      ]);

      if ($request->isApi()) return response()->json(['rsp' => $admin], 201);
      return back()->withFlash(['success' => 'Funding successful']);
    } catch (\Throwable $e) {

      ErrLog::notifySuperAdminAndFail($request->user(), $e, 'Error funding admin account');

      if ($request->isApi()) return response()->json(['rsp' => 'error occurred'], 500);
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
