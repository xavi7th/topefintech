<?php

namespace App\Modules\Admin\Http\Controllers;

use App\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\Admin\Models\ActivityLog;
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
    $this->middleware('throttle:5,1')->except(['admin.login.show']);
    $this->middleware('guest:web,agent,admin')->only(['showLoginForm', 'login']);
    $this->middleware('auth:admin')->only(['logout']);
  }

  static function routes()
  {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login.show')->defaults('extras', ['nav_skip' => true]);
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
    Route::post('first-time', [LoginController::class, 'newAdminSetPassword'])->name('admin.password.new');
    Route::match(['get', 'post'], 'logout', [LoginController::class, 'logout'])->name('admin.logout')->defaults('extras', ['nav_skip' => true]);
  }

  /**
   * Show the application's login form.
   *
   * @return \Illuminate\Http\Response
   */
  public function showLoginForm(Request $request)
  {
    return Inertia::render('Admin,auth/Login');
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

      ActivityLog::notifyAdmins($this->guard()->user()->email  . ' logged into the admin dashboard');

      return $this->sendLoginResponse($request);
    }

    $this->incrementLoginAttempts($request);

    return $this->sendFailedLoginResponse($request);
  }


  public function newAdminSetPassword()
  {
    $admin = Admin::where('email', request('email'))->firstOrFail();
    if ($admin && !$admin->is_verified()) {
      Db::beginTransaction();

      $admin->password = request('pw');
      $admin->verified_at = now();
      $admin->save();

      DB::commit();

      // $this->guard()->login($admin);

      return redirect()->back()->withFlash(['success' => 'Password set! You may now log in using your new password']);
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

    return redirect()->route('admin.login');
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
  protected function authenticated(Request $request, Admin $user)
  {
    if ($user->isAdmin()) {
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
  protected function apiGuard()
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
