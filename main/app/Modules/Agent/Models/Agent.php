<?php

namespace App\Modules\Agent\Models;

use Cache;
use App\User;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Modules\Admin\Transformers\AdminUserTransformer;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Transformers\AppUserTransformer;

/**
 * App\Modules\Agent\Models\Agent
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string|null $bvn
 * @property string|null $avatar
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereBvn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereVerifiedAt($value)
 * @mixin \Eloquent
 * @property string|null $ref_code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Agent\Models\Agent whereRefCode($value)
 */
class Agent extends User
{
  protected $fillable = [
    'role_id', 'full_name', 'email', 'password', 'phone', 'bvn', 'user_passport', 'gender', 'address', 'dob',
  ];

  protected $dates = ['dob', 'verified_at'];

  const DASHBOARD_ROUTE_PREFIX = 'smart-collectors';

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    Inertia::setRootView('agent::app');
  }

  public function managed_users()
  {
    return $this->hasMany(AppUser::class);
  }

  static function findByRefCode(string $refCode): self
  {
    return self::whereRefCode($refCode)->first();
  }

  public function is_verified(): bool
  {
    return $this->verified_at !== null;
  }

  static function send_notification($notification)
  {
    self::find(1)->notify($notification);
  }

  static function agentRoutes()
  {
    Route::group([], function () {
      Route::get('notifications', [self::class, 'getAgentNotifications'])->name('agent.notifications')->defaults('extras', ['nav_skip' => true]);
      Route::get('managed-users', [self::class, 'getListOfUsers'])->name('agent.manage_users')->defaults('extras', ['icon' => 'fas fa-users']);
      Route::get('{appUser:phone}/savings', [self::class, 'agentViewManagedUserSavings'])->name('agent.user_savings')->defaults('extras', ['nav_skip' => true]);
      Route::get('user/{appUser:phone}/statement', [self::class, 'agentGetManagedUserAccountStatement'])->name('agent.user.statement')->defaults('extras', ['nav_skip' => true]);
      Route::get('{appUser:phone}/savings-interest', [self::class, 'agentGetManagedUserSavingsInterests'])->name('agent.user.interest')->defaults('extras', ['nav_skip' => true]);
    });
  }

  static function adminRoutes()
  {
    Route::group([], function () {
      Route::get('agents', [self::class, 'getAgents'])->name('admin.view_agents')->defaults('extras', ['icon' => 'fas fa-user-tie']);
      Route::post('agent/create', [self::class, 'createAgent'])->name('admin.create_agent');
    });
  }

  public function getListOfUsers(Request $request)
  {
    $managedUsers = (new AppUserTransformer)->collectionTransformer($request->user()->managed_users, 'forAgents');

    if ($request->isApi()) return $managedUsers;
    return Inertia::render('Agent,ManageUsers', compact('managedUsers'));
  }

  public function agentGetManagedUserAccountStatement(Request $request, AppUser $appUser)
  {
    $userStatement = cache()->remember('users', config('cache.account_statement_cache_duration'), function () use ($appUser) {
      return $appUser->load([
        'savings_interests.savings.target_type',
        'service_charges',
        'transactions'
      ]);
    });

    $account_statement = collect($userStatement->savings_interests)
      ->merge($userStatement->service_charges)
      ->merge($userStatement->transactions)->sortByDesc('created_at')->values();

    if ($request->isApi()) {
      return $account_statement;
    }

    return Inertia::render('AppUser,savings/AdminViewUserTransactionHistory', compact('account_statement', 'appUser'));
  }

  public function agentViewManagedUserSavings(Request $request, AppUser $user)
  {
    $savings_list = $user->savings_list->load('target_type');
    $auto_save_list = $user->auto_save_settings;
    // $target_types = TargetType::all();

    return Inertia::render('Admin,savings/ManageUserSavings', compact('user', 'savings_list', 'auto_save_list'));
  }

  public function agentGetManagedUserSavingsInterests(Request $request, AppUser $appUser)
  {
    $records = $appUser->savings_interests()->with('savings.target_type')->addSelect(DB::raw('*, MONTHNAME(savings_interests.created_at) as month'))->get();
    // dd($appUser);
    $interests_summary =  transform($records, function ($value) {
      return $value->groupBy('month')->transform(function ($item, $key) {
        return $item->groupBy('savings.target_type.name')->transform(function ($item, $key) {
          return $item->sum('amount');
        });
      })->transform(function ($item) {
        return collect($item->all())->merge(['total' => $item->sum()]);
      });
    });

    if ($request->isApi()) {
      return response()->json($interests_summary, 200);
    } else {
      return Inertia::render('AppUser,savings/ViewUserInterests', [
        'interests_summary' => $interests_summary,
        'user' => $appUser
      ]);
    }
  }

  public function getAgentNotifications(Request $request)
  {
    $request->user()->unreadNotifications->markAsRead();

    if ($request->isApi()) return $request->user()->notifications;
    return Inertia::render('Agent,AgentNotifications', [
      'notifications' => $request->user()->notifications
    ]);
  }

  public function getAgents(Request $request)
  {

    $agents = Cache::rememberForever('allAgents', function () {
      return (new AdminUserTransformer)->collectionTransformer(self::all(), 'transformForAdminViewAgents');
    });

    if ($request->isApi()) return $agents;
    return Inertia::render('Admin,ManageAgents', compact('agents'));
  }

  public function createAgent(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'full_name' => 'required|max:255',
      'phone' => 'required|max:20|unique:agents,email',
      'email' => 'required|email',
    ]);

    if ($validator->fails()) {
      return back()
        ->withErrors($validator)
        ->withError('There are errors in your form');
    }

    try {
      DB::beginTransaction();
      $agent = self::create(Arr::collapse([
        $validator->validated(),
        [
          'password' => bcrypt('amju@agent')
        ]
      ]));

      DB::commit();

      if ($request->isApi()) return response()->json(['rsp' => $agent], 201);
      return back()->withSuccess('Agent account created. They will be required to set a password om their first login');
    } catch (\Throwable $e) {

      ErrLog::notifyAdminAndFail($request->user(), $e, 'Error creating agent account');

      if ($request->isApi()) return response()->json(['rsp' => 'error occurred'], 500);
      return back()->withError('An error occurred. Check the error logs');
    }
  }

  /**
   * The "booted" method of the model.
   *
   * @return void
   */
  protected static function booted()
  {
    static::creating(function ($user) {
      $user->ref_code = unique_random('agents', 'ref_code', 'SMC-', '9');
    });
  }
}
