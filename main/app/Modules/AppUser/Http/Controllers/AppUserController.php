<?php

namespace App\Modules\AppUser\Http\Controllers;


use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Transformers\AppuserTransformer;
use App\Modules\AppUser\Http\Controllers\LoginController;
use App\Modules\AppUser\Http\Controllers\RegisterController;
use App\Modules\AppUser\Http\Controllers\VerificationController;
use App\Modules\AppUser\Http\Requests\EditUserProfileValidation;
use App\Modules\AppUser\Http\Controllers\ResetPasswordController;
use App\Modules\AppUser\Http\Controllers\ForgotPasswordController;
use App\Modules\AppUser\Http\Controllers\ConfirmPasswordController;


class AppUserController extends Controller
{
	/**
	 * The normal user routes that require authentication
	 * @return Response
	 */
	public static function routes()
	{
		LoginController::routes();
		RegisterController::routes();
		// ResetPasswordController::routes();
		// ForgotPasswordController::routes();
		// ConfirmPasswordController::routes();
		VerificationController::routes();

		Route::get('/auth/verify', function () {
			if (Auth::check()) {
				return ['LOGGED_IN' => true, 'user' => Auth::user()];
			} else {
				return ['LOGGED_IN' => false];
			}
		})->prefix(AppUser::DASHBOARD_ROUTE_PREFIX);

		Route::group(['middleware' => ['auth', 'email_verified', 'appusers'], 'prefix' => AppUser::DASHBOARD_ROUTE_PREFIX], function () {

			Route::group(['prefix' => 'api'], function () {

				Route::get('/profile', function () {
					return (new AppuserTransformer)->transformForAppUser(Auth::appuser());
				});
				Route::put('/profile/edit', function (EditUserProfileValidation $request) {
					// return request()->all();
					Auth::appuser()->update([
						'email' => request('email') ?? Auth::appuser()->email,
						'password' => request('password') ?? Auth::appuser()->unenc_password,
						'name' => request('name') ?? Auth::appuser()->name,
					]);
					return response()->json(['updated' => true], 205);
				});
			});

			Route::get('/{subcat?}', function () {
				// Auth::logout();
				// dd(Auth::appuser());
				return view('appuser::index');
			})->name('appuser.dashboard')->where('subcat', '^((?!(api)).)*'); //Matches all routes except routes that start with the list provided.
		});
	}
}
