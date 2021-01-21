<?php

namespace App\Modules\SuperAdmin\Models;

use App\User;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Admin;
use App\Modules\Admin\Models\ErrLog;
use App\Modules\Admin\Models\ServiceCharge;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\Savings;
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Models\Transaction;
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
    Route::name('superadmin.')->group(function () {
      Route::get('notifications', [self::class, 'getSuperAdminNotifications'])->name('notifications')->defaults('extras', ['nav_skip' => true]);
      Route::get('transactions/all', [self::class, 'getAllTransactions'])->name('transaction_logs')->defaults('extras', ['icon' => 'fa fa-briefcase']);
    });
  }

  public function getSuperAdminNotifications(Request $request)
  {
    $request->user()->unreadNotifications->markAsRead();
    return Inertia::render('SuperAdmin,SuperAdminNotifications', ['notifications' => $request->user()->notifications]);
  }

  public function getAllTransactions(Request $request)
  {
    // $allTransactions = cache()->remember(
    //   'transactions',
    //   1,
    //   fn () => SavingsInterest::with('savings.portfolio')->latest('id')->get()->merge(ServiceCharge::latest('id')->get())->merge(Transaction::latest('id')->get())
    //   // collect([
    //   //   'savings_interests' => SavingsInterest::with('savings.portfolio')->latest('id')->get(),
    //   //   'service_charges' => ServiceCharge::latest('id')->get(),
    //   //   'transactions' => Transaction::latest('id')->get()
    //   // ])
    // );

    $records = $s = Savings::with('savings_interests.app_user', 'service_charges.app_user', 'transactions.app_user')->get();

    $allTransactions = $records->pluck('transactions')->reduce(fn ($carry, $item) => $carry->merge($item), collect([]))->transform(fn ($item) => (collect($item)->only(['amount', 'description', 'trans_type', 'created_at', 'app_user'])))
      ->merge($records->pluck('service_charges')->reduce(fn ($carry, $item) => $carry->merge($item), collect([]))->transform(fn ($item) => (collect($item)->only(['amount', 'description', 'created_at', 'app_user'])->merge(['trans_type' => 'Service Charge']))))
      ->merge($records->pluck('savings_interests')->reduce(fn ($carry, $item) => $carry->merge($item), collect([]))->transform(fn ($item) => (collect($item)->only(['amount', 'description', 'created_at', 'app_user'])->merge(['trans_type' => 'Interests']))))
      ->sortByDesc('created_at')
      ->values();
    // ->toArray();


    debug($allTransactions);


    // return collect($allTransactions->savings_interests)
    //   ->merge($allTransactions->service_charges)
    //   ->merge($allTransactions->transactions)->sortByDesc('created_at')->values();

    return Inertia::render('SuperAdmin,savings/ViewTransactionHistory', compact('allTransactions'));
  }
}
