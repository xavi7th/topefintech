<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\Admin\Models\ActivityLog;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

/**
 *
 *  Login Controller
 * --------------------------------------------------------------------------
 *  This controller handles authenticating users for the application and
 *  redirecting them to your home screen. The controller uses a trait
 *  to conveniently provide its functionality to your applications.
 *
 */
class LoginController extends Controller
{

  use AuthenticatesUsers;

  private $apiToken;
  protected $decayMinutes = 1440;
  protected $maxAttempts = 5;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  // protected $redirectTo = route('appuser.dashboard');
  protected function redirectTo()
  {
    return route(User::dashboardRoute());
  }

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    Inertia::setRootView('appuser::app');
  }

  static function routes()
  {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('app.login')->defaults('extras', ['nav_skip' => true]);
    Route::post('login', 'LoginController@login')->middleware('guest')->name('appuser.login');
    Route::post('logout', 'LoginController@logout')->name('appuser.logout')->middleware('auth');
  }

  public function showLoginForm(Request $request)
  {
    return Inertia::render('auth/Login');
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

    // If the class is using the ThrottlesLogins trait, we can automatically throttle
    // the login attempts for this application. We'll key this by the username and
    // the IP address of the client making these requests into this application.
    if (
      method_exists($this, 'hasTooManyLoginAttempts') &&
      $this->hasTooManyLoginAttempts($request)
    ) {
      $this->fireLockoutEvent($request);

      return $this->sendLockoutResponse($request);
    }

    if ($this->attemptLogin($request)) {
      /**
       * ? Log the user into the api guard also
       */
      $this->apiToken = $this->apiGuard()->attempt($this->credentials($request));

      ActivityLog::notifyAdmins($this->guard()->user()->email  . ' logged into the super admin dashboard');

      return $this->sendLoginResponse($request);
    }

    // If the login attempt was unsuccessful we will increment the number of attempts
    // to login and redirect the user back to the login form. Of course, when this
    // user surpasses their maximum number of attempts they will get locked out.
    $this->incrementLoginAttempts($request);

    return $this->sendFailedLoginResponse($request);
  }

  /**
   * Validate the user login request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return void
   */
  protected function validateLogin(Request $request)
  {
    $this->validate($request, [
      $this->username() => 'required|string',
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
  protected function authenticated(Request $request, AppUser $user)
  {
    if ($user->isAppUser()) {
      if (Auth::appuser()->is_email_verified()) {
        // config(['session.lifetime' => (string)(1 * (60 * 24 * 365))]);
        if ($request->isApi()) {
          return response()->json($this->respondWithToken($this->apiToken), 202);
        }
        return redirect()->route($user->dashboardRoute());
      } else {
        Auth::logout();
        session()->invalidate();
        if ($request->isApi()) {
          return response()->json(['message' => 'Unverified user'], 416);
        }
        return back()->withError('Your account has not been verified. Check your email for a verification mail.');
      }
    } else {
      Auth::logout();
      session()->invalidate();
      if ($request->isApi()) {
        return response()->json(['message' => 'Access Denied'], 401);
      }
      abort(401, 'Access Denied');
    }
    return redirect()->route('app.login');
  }

  public function logout(Request $request)
  {
    $this->guard()->logout();
    $request->session()->invalidate();

    try {
      $this->apiGuard()->logout();
    } catch (\Throwable $th) { }

    if ($request->isApi()) {
      return response()->json(['logged_out' => true], 200);
    }
    return redirect()->route('app.login');
  }

  /**
   * Get the login username to be used by the controller.
   *
   * @return string
   */
  public function username()
  {
    return 'email';
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return array api jwt token details
   */
  protected function respondWithToken($token)
  {
    return [
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => $this->apiGuard()->factory()->getTTL() * 60
    ];
  }

  /**
   * Get the guard to be used during authentication.
   *
   * @return \Illuminate\Contracts\Auth\StatefulGuard
   */
  protected function guard()
  {
    return Auth::guard();
  }

  protected function apiGuard()
  {
    return Auth::guard('api_user');
  }
}
