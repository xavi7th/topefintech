<?php

namespace App\Modules\AppUser\Http\Controllers;


use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\GOSType;
use App\Modules\AppUser\Models\Savings;
use App\Modules\AppUser\Models\DebitCard;
use App\Modules\AppUser\Models\LoanSurety;
use App\Modules\AppUser\Models\LoanRequest;
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

	public static function apiRoutes()
	{
		Route::group(['middleware' => ['api', 'throttle:20,1'], 'prefix' => '/api/',  'namespace' => '\App\Modules\AppUser\Http\Controllers'], function () {

			LoginController::routes();

			RegisterController::apiRoutes();

			ErrLog::apiRoutes();

			Route::group(['middleware' => ['auth:api_user', 'email_verified', 'appusers'], 'prefix' => AppUser::DASHBOARD_ROUTE_PREFIX], function () {

				AppUser::apiRoutes();

				Savings::appUserRoutes();

				GOSType::appUserRoutes();

				DebitCard::appUserRoutes();

				LoanRequest::appUserRoutes();

				LoanSurety::appUserRoutes();
			});
		});
	}

	/**
	 * @return Response
	 */
	public static function routes()
	{

		Route::group(['middleware' => 'web', 'namespace' => 'App\Modules\AppUser\Http\Controllers'], function () {

			LoginController::routes();
			RegisterController::webRoutes();
			// ResetPasswordController::routes();
			// ForgotPasswordController::routes();
			// ConfirmPasswordController::routes();
			VerificationController::routes();

			AppUser::routes();

			Route::group(['middleware' => ['auth', 'email_verified', 'appusers'], 'prefix' => AppUser::DASHBOARD_ROUTE_PREFIX], function () {
				/**
				 ** Matches all routes except routes that start with the list provided.
				 */
				Route::get('/{subcat?}', 'AppUserController@loadUserApp')->name('appuser.dashboard')->where('subcat', '^((?!(api)).)*');
			});
		});
	}

	public function loadUserApp()
	{
		// Auth::logout();
		// dd(Auth::appuser());
		return view('appuser::index');
	}
}
