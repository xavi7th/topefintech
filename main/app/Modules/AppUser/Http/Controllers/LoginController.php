<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\Admin\Models\ActivityLog;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Modules\AppUser\Notifications\SendPasswordResetLink;
use App\Modules\AppUser\Notifications\SendAccountVerificationMessage;

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
    Route::post('login', [self::class, 'login'])->middleware('guest')->name('appuser.login');
    Route::post('logout', [self::class, 'logout'])->name('appuser.logout')->middleware('auth');
    Route::post('verify-otp', [self::class, 'verifyUserToken'])->name('appuser.otp.verify')->defaults('extras', ['nav_skip' => true]);
    Route::match(['get', 'post'], 'request-password-reset', [self::class, 'showRequestPasswordForm'])->name('appuser.password_reset.request')->defaults('extras', ['nav_skip' => true]);
    Route::get('reset-password', [self::class, 'showResetPasswordForm'])->name('appuser.password_reset.verify')->defaults('extras', ['nav_skip' => true]);
    Route::put('reset-password', [self::class, 'resetUserPassword'])->name('appuser.password_reset.change_password')->defaults('extras', ['nav_skip' => true]);
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

      ActivityLog::notifyAdmins($this->guard()->user()->phone  . ' logged into their dashboard');

      return $this->sendLoginResponse($request);
    }

    // If the login attempt was unsuccessful we will increment the number of attempts
    // to login and redirect the user back to the login form. Of course, when this
    // user surpasses their maximum number of attempts they will get locked out.
    $this->incrementLoginAttempts($request);

    return $this->sendFailedLoginResponse($request);
  }

  public function verifyUserToken(Request $request)
  {
    $tokenRecord = DB::table('password_resets')->where('token', $request->otp)->first();

    if (!$tokenRecord) {
      return back()->withError('Phone number could not be verified. Invalid token!');
    } else {
      DB::beginTransaction();

      $user = AppUser::where('phone', $tokenRecord->phone)->first();

      $user->verified_at = now();
      $user->save();

      DB::table('password_resets')->where('token', $tokenRecord->token)->delete();

      $user->notify(new SendAccountVerificationMessage('database'));

      DB::commit();

      /**
       * Log the user in and redirect to dashboard
       */
      $this->guard()->login($user);

      return redirect()->route($user->dashboardRoute())->withSuccess('Account verified successfully. Welcome to ' . config('app.name'));
    }
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

  public function showRequestPasswordForm(Request $request)
  {
    if ($request->isMethod('GET')) {
      return Inertia::render('auth/RequestPasswordReset');
    } else if ($request->isMethod('POST')) {
      if (!$request->phone) {
        return generate_422_error('An phone number is required to reset your password');
      }
      try {
        $user = AppUser::where('phone', $request->phone)->firstOrFail();

        $token = $user->createVerificationToken();
        $user->notify(new SendPasswordResetLink($token));
      } catch (ModelNotFoundException $th) { }

      return redirect()->route('appuser.password_reset.verify')->withSuccess('If the phone number is valid, a password reset otp will be sent to you via sms. Follow the instructions to reset your password');
    }
  }

  public function showResetPasswordForm(Request $request, string $token)
  {
    $tokenRecord = DB::table('password_resets')->where('token', $token)->first();

    if (!$tokenRecord) {
      return redirect()->route('appuser.password_reset.request')->withError('Password reset token could not be verified. Invalid token!');
    }
    if (now()->subHours(6)->gte(Carbon::parse($tokenRecord->created_at))) {
      DB::table('password_resets')->where('token', $tokenRecord->token)->delete();
      return redirect()->route('appuser.password_reset.request')->withError('Password reset token could completed. This link has expired. Try again!');
    } else {
      return Inertia::render('auth/ResetPassword', compact('token'));
    }
  }

  public function resetUserPassword(Request $request)
  {
    $validated = Validator::make($request->all(), [
      'password' => 'required|max:50|confirmed',
      'token' => 'required|exists:password_resets,token'
    ])->validate();

    DB::beginTransaction();

    $tokenRecord = DB::table('password_resets')->where('token', $validated['token'])->first();
    $user = AppUser::where('phone', $tokenRecord->phone)->first();

    $user->password = $request->password;
    $user->save();

    DB::table('password_resets')->where('token', $validated['token'])->delete();

    DB::commit();

    return redirect()->route('app.login')->withSuccess('Password reset successfully. Login to access your dashboard');
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
      if ($user->is_verified()) {
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
        return back()->withError(416);
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

  /**
   * Get the login username to be used by the controller.
   *
   * @return string
   */
  public function username()
  {
    return 'phone';
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
