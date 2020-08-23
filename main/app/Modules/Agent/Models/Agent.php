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

  public function is_verified()
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
    });
  }

  static function adminRoutes()
  {
    Route::group([], function () {
      Route::get('agents', [self::class, 'getAgents'])->name('admin.view_agents')->defaults('extras', ['icon' => 'fas fa-user-tie']);
      Route::post('agent/create', [self::class, 'createAgent'])->name('admin.create_agent');
    });
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
