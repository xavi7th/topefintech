<?php

namespace App\Modules\SuperAdmin\Http\Controllers;

use Inertia\Inertia;
use Tymon\JWTAuth\JWTGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\Admin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 *
 *  Login Controller
 * --------------------------------------------------------------------------
 *  This controller handles authenticating admins for the application and
 *  redirecting them to the admin dashboard screen. The controller uses a trait
 *  to conveniently provide its functionality to your applications.
 *
 */
class LoginController extends Controller
{

  use AuthenticatesUsers;

  protected $apiToken;

  /**
   * Where to redirect admins after login.
   *
   * @var string
   */
  protected function redirectTo()
  {
    return route(request()->user()->dashboardRoute());
  }

  public function __construct()
  {
    $this->middleware('throttle:5,1')->except(['superadmin.login.show']);
    $this->middleware('guest:web,agent,admin,superadmin')->only(['showLoginForm', 'login']);
    $this->middleware('auth:superadmin')->only(['logout', 'newSuperAdminSetPassword']);
  }

  static function routes()
  {
    Route::get('login', [self::class, 'showLoginForm'])->name('superadmin.login.show')->defaults('extras', ['nav_skip' => true]);
    Route::post('login', [self::class, 'login'])->name('superadmin.login');
    // Route::post('first-time', [self::class, 'newSuperAdminSetPassword'])->name('superadmin.password.new');
    Route::match(['get', 'post'], 'logout', [self::class, 'logout'])->name('superadmin.logout');
  }

  /**
   * Show the application's login form.
   *
   * @return \Illuminate\Http\Response
   */
  public function showLoginForm(Request $request)
  {
    return Inertia::render('SuperAdmin,auth/Login');
  }

  /**
   * Handle a login request to the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
   *
   * @throws \Illuminate\Validation\ValidationException
   */
  public function login(Request $request)
  {
    $this->validateLogin($request);
    if (
      method_exists($this, 'hasTooManyLoginAttempts') &&
      $this->hasTooManyLoginAttempts($request)
    ) {
      $this->fireLockoutEvent($request);

      return $this->sendLockoutResponse($request);
    }

    if ($this->attemptLogin($request)) {

      $this->apiToken = $this->apiGuard()->attempt($this->credentials($request));

      ActivityLog::notifySuperAdmins($this->guard()->user()->email  . ' logged into the super admin dashboard');

      return $this->sendLoginResponse($request);
    }

    $this->incrementLoginAttempts($request);

    return $this->sendFailedLoginResponse($request);
  }


  public function newSuperAdminSetPassword()
  {
    $superAdmin = SuperAdmin::where('email', request('email'))->firstOrFail();
    if ($superAdmin && !$superAdmin->is_verified()) {
      DB::beginTransaction();

      $superAdmin->password = request('pw');
      $superAdmin->verified_at = now();
      $superAdmin->save();

      DB::commit();

      $this->guard()->login($superAdmin);

      return redirect()->route($superAdmin->dashboardRoute())->withFlash(['success' => 'Password set']);
    }
    return back()->withFlash(['error' => 'Unauthorised']);
  }

  /**
   * Log the user out of the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function logout(Request $request)
  {
    $this->guard()->logout();

    $request->session()->invalidate();

    try {
      $this->apiGuard()->logout();
    } catch (\Throwable $th) {
    }

    return redirect()->route('superadmin.login');
  }



  protected function validateLogin(Request $request)
  {
    $this->validate($request, [
      $this->username() => 'required|email',
      'password' => 'required|string',
    ]);
  }

  /**
   * The user has been authenticated. We can redirect them to where we want or leave empty for the redirectto property to handle
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  mixed  $user
   * @return mixed
   */
  protected function authenticated(Request $request, SuperAdmin $user)
  {
    if ($user->isSuperAdmin()) {
      if ($user->is_verified()) {
        if ($request->isApi())
          return response()->json($this->respondWithToken(), 202);

        return redirect()->route($user->dashboardRoute());
      } else {
        $this->logout($request);

        if ($request->isApi()) return response()->json(['unverified' => 'Unverified user'], 416);
        return back()->withFlash(['error' => ['unverified' => 'Unverified user']]);
      }
    } else {
      $this->logout($request);
      if ($request->isApi())
        return response()->json(['message' => 'Access Denied'], 401);

      abort(401, 'Access Denied');
    }
  }

  /**
   * Get the login username to be used by the controller.
   *
   * @return string
   */
  public function username(): string
  {
    return 'email';
  }

  /**
   * Get the guard to be used during authentication.
   *
   * @return \Illuminate\Contracts\Auth\StatefulGuard
   */
  protected function guard()
  {
    return Auth::guard('admin');
  }

  /**
   * Get the guard to be used during authentication.
   *
   * @return \Illuminate\Contracts\Auth\StatefulGuard
   */
  protected function apiGuard(): JWTGuard
  {
    return Auth::guard('admin_api');
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return array api jwt token details
   */
  protected function respondWithToken(): array
  {
    return [
      'access_token' => $this->apiToken,
      'token_type' => 'bearer',
      'expires_in' => $this->apiGuard()->factory()->getTTL() * 60,
      'status' => true
    ];
  }
}
