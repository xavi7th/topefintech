<?php

namespace App\Modules\Admin\Http\Controllers;

use App\User;
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
		return route(Admin::dashboardRoute());
	}

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('guest:admin')->except('logout');
	}

	static function routes()
	{
		Route::get('login', 'LoginController@showLoginForm')->middleware('guest:admin')->name('admin.login');
	}

	static function apiRoutes()
	{
		Route::post('login', 'LoginController@login')->middleware('throttle:5,1'); //->middleware('verified');
		Route::post('first-time', 'LoginController@resetPassword')->middleware('guest:admin_api')->middleware('throttle:5,1');
		Route::post('logout', 'LoginController@logout')->name('admin.logout');
	}

	/**
	 * Show the application's login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showLoginForm(Request $request)
	{
		Log::channel('database')->info('Method Not Allowed Exception', ['$e_obj' => $request->getRequestUri()]);
		return view('admin::auth');
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
			 * ? Log the user into the admin api guard also
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
	 * Show the application's login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function resetPassword()
	{
		$admin = Admin::where('email', request('email'))->firstOrFail();
		if ($admin && !$admin->is_verified()) {
			Db::beginTransaction();

			$admin->password = bcrypt(request('pw'));
			$admin->verified_at = now();
			$admin->permitted_api_routes()->attach(1);
			$admin->save();

			DB::commit();

			$this->guard()->login($admin);

			return response()->json(['status' => true], 204);
		}
		return response()->json(['status'], 403);
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
	protected function authenticated(Request $request, $user)
	{
		if ($user->isAdmin()) {
			if ($user->is_verified()) {
				return response()->json($this->respondWithToken(), 202);
			} else {
				$this->logout($request);
				return response()->json(['message' => 'Unverified user'], 416);
			}
		} else {
			$this->logout($request);
			return response()->json(['message' => 'Access Denied'], 401);
		}
		return redirect()->route(Admin::dashboardRoute());
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
		} catch (\Throwable $th) { }

		if ($request->ajax() || $request->expectsJson()) {
			return response()->json(['logged_out' => true], 200);
		}

		return redirect()->route('admin.login');
	}

	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return array api jwt token details
	 */
	protected function respondWithToken()
	{
		return [
			'access_token' => $this->apiToken,
			'token_type' => 'bearer',
			'expires_in' => $this->apiGuard()->factory()->getTTL() * 60,
			'status' => true
		];
	}
}
