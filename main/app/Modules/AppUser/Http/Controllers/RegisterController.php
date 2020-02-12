<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Registered;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Modules\AppUser\Http\Requests\RegistrationValidation;
use App\Modules\AppUser\Notifications\CoreSavingsInitialised;

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
		$this->middleware('guest');
	}

	/**
	 * The routes for registration
	 *
	 * @return void
	 */
	static function routes()
	{
		Route::get('/register', function () {
			Auth::logout();
			return view('appuser::index');
		})->name('register'); //->middleware('guest');

		Route::post('register', 'RegisterController@register');
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function register(RegistrationValidation $request)

	{

		event(new Registered($user = $this->create($request->all())));

		// dd($user);
		$this->guard()->login($user);

		return $this->registered($request, $user)
			?: redirect($this->redirectPath());
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\User
	 */
	protected function create(array $data)
	{

		// $url = request()->file('id_card')->store('public/id_cards');
		// Storage::setVisibility($url, 'public');

		/** Replace the public part of the url with storage to make it accessible on the frontend */
		// $url = Str::replaceFirst('public', '/storage', $url);

		//Create an entry into the documents database

		/**
		 * @todo Create a referral record if any
		 * ! If there is a referral ID create a referral entry for the agent
		 */

		return AppUser::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => $data['password'],
		]);
	}

	/**
	 * The user has been registered.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
	protected function registered(Request $request, $user)
	{
		//
		Log::critical($user->email . ' registered an account on the site.');
		/**
		 * Create an empty Savings profile for him with 100% savings distribution
		 */
		$user->savings_list()->create([
			'savings_distribution' => 100,
		]);

		/**
		 * Notify the user that a core savings account prifile was initialised for him. He can start saving right away
		 */

		$user->notify(new CoreSavingsInitialised($user));

		/**
		 * TODO Notify the referrer if any
		 * @todo Notify the referrer if any
		 */

		if ($request->ajax()) {
			return response()->json(['status' => true], 201);
		}
		return redirect('/login');
	}
}
