<?php

namespace App\Modules\AppUser\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Registered;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\Admin\Models\ActivityLog;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Modules\AppUser\Transformers\AppUserTransformer;
use App\Modules\AppUser\Http\Requests\RegistrationValidation;
use App\Modules\AppUser\Notifications\SmartSavingsInitialised;
use App\Modules\AppUser\Notifications\SendAccountVerificationMessage;

class RegisterController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

  use RegistersUsers;

  private $apiToken;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  // protected $redirectTo = route('appuser.dashboard');
  protected function redirectTo()
  {
    return route('appuser.dashboard');
  }

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    Inertia::setRootView('appuser::app');
    $this->middleware('guest');
  }

  /**
   * The routes for registration
   *
   * @return void
   */
  static function routes()
  {
    Route::group(['middleware' => 'guest'], function () {
      Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('app.create_account')->defaults('extras', ['nav_skip' => true]);
      Route::post('register', [RegisterController::class, 'register'])->name('appuser.register');
    });
  }

  public function showRegistrationForm()
  {
    return Inertia::render('AppUser,auth/Register');
  }

  /**
   * Handle a registration request for the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function register(RegistrationValidation $request)
  {
    DB::beginTransaction();

    event(new Registered($user = $this->create($request)));

    return $this->registered($request, $user)
      ?: redirect($this->redirectPath());
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function create(Request $request): AppUser
  {
    /**
     * @todo Create a referral record if any
     * ! If there is a referral ID create a referral entry for the agent
     */

    return AppUser::create($request->validated());
  }

  /**
   * The user has been registered.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  mixed  $user
   * @return mixed
   */
  protected function registered(Request $request, AppUser $user)
  {
    ActivityLog::notifyAdmins($user->phone   . ' registered an account on the site.');

    $token = $user->createVerificationToken();
    $user->notify((new SendAccountVerificationMessage('sms', $token))->onQueue('high'));

    /**
     * TODO Notify the referrer if any
     * @todo Notify the referrer if any
     */

    DB::commit();

    if ($request->isApi()) {
      return $this->respondWithToken();
    }
    return redirect()->route('app.login')->withSuccess('Account Created');
  }

  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  protected function respondWithToken()
  {
    return response()->json([
      'access_token' => $this->apiToken,
      'token_type' => 'bearer',
      'expires_in' => $this->apiGuard()->factory()->getTTL() * 60,
      'user' => (new AppUserTransformer)->basic($user = auth()->user()),
    ], 201);
  }

  protected function apiGuard()
  {
    return Auth::guard('api_user');
  }
}
