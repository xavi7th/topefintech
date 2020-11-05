<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\User;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\DB;
use App\Modules\Agent\Models\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
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
    // $this->middleware('guest');
  }

  static function routes()
  {
    Route::get('/login', [self::class, 'showLoginForm'])->middleware('guest:web,agent')->name('app.login')->defaults('extras', ['nav_skip' => true]);
    Route::post('login', [self::class, 'login'])->middleware('guest:web,agent')->name('appuser.login');
    // Route::post('logout', [self::class, 'logout'])->name('appuser.logout')->middleware('auth');
    Route::match(['GET', 'POST'], 'logout', [self::class, 'logout'])->name('appuser.logout')->middleware('auth:web,agent');
    Route::post('verify-otp', [self::class, 'verifyUserToken'])->name('appuser.otp.verify')->defaults('extras', ['nav_skip' => true]);
    Route::match(['get', 'post'], 'request-password-reset', [self::class, 'showRequestPasswordForm'])->name('appuser.password_reset.request')->defaults('extras', ['nav_skip' => true]);
    Route::get('reset-password', [self::class, 'showResetPasswordForm'])->name('appuser.password_reset.verify')->defaults('extras', ['nav_skip' => true]);
    Route::put('reset-password', [self::class, 'resetUserPassword'])->name('appuser.password_reset.change_password')->defaults('extras', ['nav_skip' => true]);
    Route::post('password/set', [self::class, 'newAgentSetPassword'])->name('app.password.new');
  }

  public function showLoginForm(Request $request)
  {
    return Inertia::render('AppUser,auth/Login');
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

      // ActivityLog::notifyAdmins($this->authenticatedGuard()->user()->phone  . ' logged into their dashboard');
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
      return back()->withFlash(['error' => 'Phone number could not be verified. Invalid token!']);
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

      return redirect()->route($user->dashboardRoute())->withFlash(['success' => 'Account verified successfully. Welcome to ' . config('app.name')]);
    }
  }

  public function logout(Request $request)
  {
    $this->authenticatedGuard()->logout();
    $request->session()->invalidate();

    try {
      optional($this->authenticatedApiGuard())->logout();
    } catch (\Throwable $th) {
    }

    if ($request->isApi()) return response()->json(['logged_out' => true], 200);
    // return response('', 409)->header('X-Inertia-Location', route('app.login'));
    return redirect()->route('app.login');
  }

  public function showRequestPasswordForm(Request $request)
  {
    if ($request->isMethod('GET')) {
      return Inertia::render('AppUser,auth/RequestPasswordReset');
    } else if ($request->isMethod('POST')) {
      if (!$request->phone) {
        return generate_422_error('An phone number is required to reset your password');
      }
      try {
        $user = AppUser::where('phone', $request->phone)->firstOrFail();

        $token = $user->createVerificationToken();
        $user->notify(new SendPasswordResetLink($token));
      } catch (ModelNotFoundException $th) {
      }

      return redirect()->route('appuser.password_reset.verify')->withFlash(['success' => 'If the phone number is valid, a password reset otp will be sent to you via sms. Follow the instructions to reset your password']);
    }
  }

  public function showResetPasswordForm(Request $request, string $token)
  {
    $tokenRecord = DB::table('password_resets')->where('token', $token)->first();

    if (!$tokenRecord) {
      return redirect()->route('appuser.password_reset.request')->withFlash(['error' => 'Password reset token could not be verified. Invalid token!']);
    }
    if (now()->subHours(6)->gte(Carbon::parse($tokenRecord->created_at))) {
      DB::table('password_resets')->where('token', $tokenRecord->token)->delete();
      return redirect()->route('appuser.password_reset.request')->withFlash(['error' => 'Password reset token could completed. This link has expired. Try again!']);
    } else {
      return Inertia::render('AppUser,auth/ResetPassword', compact('token'));
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

    return redirect()->route('app.login')->withFlash(['success' => 'Password reset successfully. Login to access your dashboard']);
  }

  public function newAgentSetPassword(Request $request)
  {

    try {

      $agent = Agent::where('phone', $request->phone)->firstOrFail();

      if ($agent && !$agent->is_verified()) {
        Db::beginTransaction();

        $agent->password = $request->pw;
        $agent->verified_at = now();
        $agent->save();

        DB::commit();

        Auth::guard('agent')->login($agent);

        return redirect()->route($agent->dashboardRoute())->withFlash(['success' => 'Password set']);
      }
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
      return back()->withFlash(['error' => 'Agent Not found']);
    }

    return back()->withFlash(['error' => 'Unauthorised']);
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
   * Attempt to log the user into the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return bool
   */
  protected function attemptLogin(Request $request): bool
  {
    return $this->attemptGuardLogin()
      ?? $this->attemptGuardLogin('agent')
      ?? false;
  }

  private function attemptGuardLogin(string $guard = null): ?bool
  {
    if (Auth::guard($guard)->attempt($this->credentials(request()), request()->filled('remember'))) {
      if (Arr::has(config('auth.guards'), $guard . '_api')) {
        $this->apiToken = Auth::guard($guard . '_api')->attempt($this->credentials(request()));
      }
      if (is_null($guard)) {
        $this->apiToken = $this->apiGuard()->attempt($this->credentials(request()));
      }
      return true;
    }
    return null;
  }

  /**
   * Send the response after the user was authenticated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  protected function sendLoginResponse(Request $request)
  {
    $request->session()->regenerate();

    $this->clearLoginAttempts($request);

    if ($response = $this->authenticated($request, $this->authenticatedGuard()->user())) {
      return $response;
    }

    return $request->isApi()
      ? new Response('', 204)
      : redirect()->intended(route($this->authenticatedGuard()->user()->dashboardRoute()));
  }

  /**
   * The user has been authenticated. We can redirect them to where we want or leave empty for the redirectto property to handle
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  mixed  $user
   * @return mixed
   */
  protected function authenticated(Request $request, User $user)
  {
    if ($user->isAppUser()) {
      if ($user->is_verified()) {
        // config(['session.lifetime' => (string)(1 * (60 * 24 * 365))]);
        if ($request->isApi()) return response()->json($this->respondWithToken($this->apiToken), 202);
        return redirect()->intended(route($user->dashboardRoute()));
      } else {
        $this->logout($request);
        if ($request->isApi()) return response()->json(['message' => 'Unverified user'], 416);
        return back()->withFlash(['error' => 416]);
      }
    } else {
      if ($user->is_verified()) {
        if ($request->isApi())  return response()->json($this->respondWithToken($this->apiToken), 202);
        return redirect()->route($user->dashboardRoute());
      } else {
        $this->logout($request);
        if ($request->isApi()) {
          return response()->json(['unverified' => 'Unverified user'], 406);
        }
        return back()->withFlash(['error' => 406]);
      }
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


  protected function authenticatedGuard(): ?SessionGuard
  {
    if (Auth::guard()->check()) {
      return Auth::guard();
    } elseif (Auth::guard('agent')->check()) {
      return Auth::guard('agent');
    } elseif (Auth::guard('admin')->check()) {
      return Auth::guard('admin');
    } else {
      return null;
    }
  }

  protected function authenticatedApiGuard(): ?SessionGuard
  {
    if (Auth::guard('api_user')->check()) {
      return Auth::guard('api_user');
    } else {
      return null;
    }
  }
}
