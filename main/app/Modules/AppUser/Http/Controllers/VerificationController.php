<?php

namespace App\Modules\AppUser\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be resent if the user did not receive the original email message.
    |
    */

	use VerifiesEmails;

	/**
	 * Get the path the user should be redirected to.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return string
	 */

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
		$this->middleware('auth');
		$this->middleware('signed')->only('verify');
		$this->middleware('throttle:6,1')->only('verify', 'resend');
	}

	/**
	 * Register the typical email verification routes for an application.
	 *
	 * @return void
	 */
	static function routes()
	{
		// Route::namespace('\App\Http\Controllers\Auth')->group(function () {
		Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
		Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
		Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
		// });
	}

	/**
	 * Show the email verification notice.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request)
	{
		return $request->user()->hasVerifiedEmail()
			? redirect($this->redirectPath())
			: abort(401, 'Access denied without email verification');
	}
}
