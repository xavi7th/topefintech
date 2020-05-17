<?php

namespace App\Modules\AppUser\Http\Controllers;


use Inertia\Inertia;
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
use App\Modules\AppUser\Models\Transaction;
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Models\WithdrawalRequest;
use App\Modules\AppUser\Http\Controllers\LoginController;
use App\Modules\AppUser\Http\Controllers\RegisterController;
use App\Modules\AppUser\Http\Controllers\VerificationController;

class AppUserController extends Controller
{

  public function __construct()
  {
    Inertia::setRootView('appuser::app');
  }

  public static function apiRoutes()
  {
    Route::group(['middleware' => ['api', 'throttle:20,1'], 'prefix' => '/api/',  'namespace' => '\App\Modules\AppUser\Http\Controllers'], function () {

      ErrLog::apiRoutes();

      Route::group(['middleware' => ['auth:api_user', 'email_verified', 'appusers'], 'prefix' => AppUser::DASHBOARD_ROUTE_PREFIX], function () {

        AppUser::apiRoutes();

        Savings::appUserApiRoutes();

        GOSType::appUserApiRoutes();

        DebitCard::appUserApiRoutes();

        LoanRequest::appUserApiRoutes();

        LoanSurety::appUserApiRoutes();

        WithdrawalRequest::appUserApiRoutes();

        SavingsInterest::appUserApiRoutes();

        Transaction::appUserApiRoutes();
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
      RegisterController::routes();
      // ResetPasswordController::routes();
      // ForgotPasswordController::routes();
      // ConfirmPasswordController::routes();
      VerificationController::routes();

      AppUser::routes();

      Route::group(['middleware' => ['auth', 'email_verified', 'appusers'], 'prefix' => AppUser::DASHBOARD_ROUTE_PREFIX], function () {
        Route::get('/', 'AppUserController@loadUserApp')->name('appuser.dashboard');
      });
    });
  }

  public function loadUserApp()
  {
    // Auth::logout();
    return Inertia::render('dashboard/UserDashboard');
  }
}
