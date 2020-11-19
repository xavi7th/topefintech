<?php

namespace App\Modules\Agent\Models;

use Cache;
use App\User;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Support\Facades\Validator;
use App\Modules\AppUser\Models\TargetType;
use Illuminate\Validation\ValidationException;
use App\Modules\Admin\Transformers\AdminUserTransformer;
use App\Modules\AppUser\Transformers\AppUserTransformer;
use App\Modules\AppUser\Notifications\SmartSavingsInitialised;

class Agent extends User
{
  protected $fillable = [
    'role_id', 'full_name', 'email', 'password', 'phone', 'bvn', 'user_passport', 'gender', 'address', 'dob', 'city_of_operation'
  ];

  protected $dates = ['dob', 'verified_at'];

  const DASHBOARD_ROUTE_PREFIX = 'smart-collectors';

  public function managed_users()
  {
    return $this->hasMany(AppUser::class);
  }

  static function findByRefCode(?string $refCode): self
  {
    return self::whereRefCode($refCode)->firstOrNew();
  }

  public function is_email_verified(): bool
  {
    return $this->email_verified_at !== null;
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
      Route::post('{appUser:phone}/smart-savings/initialise', [self::class, 'initialiseSmartSavingsProfile'])->name('agent.savings.smart.initialise');

    });
  }

  static function superAdminRoutes()
  {
    Route::group([], function () {
      Route::get('agents', [self::class, 'superAdminGetAgents'])->name('superadmin.view_agents')->defaults('extras', ['icon' => 'fas fa-user-tie']);
      Route::delete('agent/{agent}/suspend', [self::class, 'suspendAgent'])->name('superadmin.suspend_agent');

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
        'savings_interests.savings.portfolio',
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

  public function agentViewManagedUserSavings(Request $request, AppUser $appUser)
  {
    if (!$appUser->is_managed_by($request->user())) {
      return back()->withFlash(['error' => 'You are not this user´s smart collector']);
    }
    $savings_list = $appUser->savings_list->load('portfolio');
    $target_types = TargetType::all();

    return Inertia::render('Agent,ViewManagedUserSavings', compact('appUser', 'savings_list', 'target_types'));
  }

  public function agentGetManagedUserSavingsInterests(Request $request, AppUser $appUser)
  {
    $records = $appUser->savings_interests()->with('savings.portfolio')->addSelect(DB::raw('*, MONTHNAME(savings_interests.created_at) as month'))->get();
    // dd($appUser);
    $interests_summary =  transform($records, function ($value) {
      return $value->groupBy('month')->transform(function ($item, $key) {
        return $item->groupBy('savings.portfolio.name')->transform(function ($item, $key) {
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

  public function initialiseSmartSavingsProfile(Request $request, AppUser $appUser)
  {
    if (!$request->duration || $request->duration < 3) {
      return back()->withFlash(['error' => 'Specify a duration greater than 3 months']);
    }


    if ($appUser->has_smart_savings()) {
      return back()->withFlash(['error' => 'User has smart savings already']);
    }

    $funds = $appUser->smart_savings()->create([
      'type' => 'smart',
      'maturity_date' => now()->addMonths($request->duration)
    ]);

    /**
     * Notify the user that a smart savings account profile was initialised for him. He can start saving right away
     */
    $appUser->notify(new SmartSavingsInitialised($appUser));

    if ($request->isApi()) return response()->json(['rsp' => $funds], 201);
    return back()->withFlash(['success' => 'Smart savings portfolio initialised successfully']);
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
      'phone' => 'required|max:20|unique:agents,phone',
      'email' => 'required|email|max:50|unique:agents,email',
      'city_of_operation' => 'required|string|max:20',
    ]);

    if ($validator->fails()) {
      return back()
        ->withErrors($validator);
    }

    // dd($validator->validated());

    try {
      DB::beginTransaction();
      $agent = self::create(Arr::collapse([
        $validator->validated(),
        [
          'password' => 'amju@agent'
        ]
      ]));

      DB::commit();

      if ($request->isApi()) return response()->json(['rsp' => $agent], 201);
      return back()->withFlash(['success' => 'Agent account created. They will be required to set a password on their first login']);
    } catch (\Throwable $e) {

      ErrLog::notifySuperAdminAndFail($request->user(), $e, 'Error creating agent account');

      if ($request->isApi()) return response()->json(['rsp' => 'error occurred'], 500);
      return back()->withFlash(['error' => 'An error occurred. Check the error logs']);
    }
  }

  public function suspendAgent(Request $request, self $agent)
  {
    if ($agent->managed_users()->exists()) throw ValidationException::withMessages(['err' => 'This agent cannot be suspended. They have clients that they are currently managing'])->status(Response::HTTP_UNPROCESSABLE_ENTITY);

    $agent->delete();
    return back()->withFlash(['success' => 'Agent Account suspended ']);
  }


  public function superAdminGetAgents(Request $request)
  {

    $agents = Cache::rememberForever('allAgents', function () {
      return (new AdminUserTransformer)->collectionTransformer(self::all(), 'transformForAdminViewAgents');
    });

    if ($request->isApi()) return $agents;
    return Inertia::render('SuperAdmin,ManageAgents', compact('agents'));
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
    static::saved(function ($user) {
      Cache::forget('allAgents');
    });
    static::deleting(function ($user) {
      Cache::forget('allAgents');
    });
  }
}
