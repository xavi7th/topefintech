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
        Route::get('/', 'AppUserController@loadUserApp')->name('appuser.dashboard')->defaults('extras', ['icon' => 'fas fa-desktop']);
        Route::get('user/savings', 'AppUserController@loadUserApp')->name('appuser.savings')->defaults('extras', ['icon' => 'fas fa-wallet']);
        Route::get('user/savings/get-distribution-details', 'AppUserController@loadUserApp')->name('appuser.savings.distribution')->defaults('extras', ['nav_skip' => true]);
        Route::get('/statement', 'AppUserController@loadUserApp')->name('appuser.statement')->defaults('extras', ['icon' => 'far fa-file-alt']);
        Route::get('/request-smart-loan', 'AppUserController@loadUserApp')->name('appuser.smart-loan')->defaults('extras', ['icon' => 'fas fa-dollar-sign']);
        Route::get('/smart-loan-logs', 'AppUserController@loadUserApp')->name('appuser.smart-loan.logs')->defaults('extras', ['nav_skip' => true]);
        Route::get('/smart-loan-details', 'AppUserController@loadUserApp')->name('appuser.smart-loan.details')->defaults('extras', ['nav_skip' => true]);
        Route::get('/make-withdrawals', 'AppUserController@loadUserApp')->name('appuser.withdraw')->defaults('extras', ['icon' => 'fas fa-money-bill-wave']);
        Route::get('/smart-interests', 'AppUserController@loadUserApp')->name('appuser.smart-interest')->defaults('extras', ['icon' => 'fas fa-money-check-alt']);
        Route::get('/my-cards', 'AppUserController@loadUserApp')->name('appuser.my-cards')->defaults('extras', ['icon' => 'far fa-credit-card']);
        Route::get('/profile', 'AppUserController@loadUserApp')->name('appuser.profile.')->defaults('extras', ['icon' => 'fa fa-user']);
        Route::get('/messages', 'AppUserController@loadUserApp')->name('appuser.messages.')->defaults('extras', ['icon' => 'fas fa-mail-bulk']);
        Route::get('/gos-plans', 'AppUserController@loadUserApp')->name('appuser.gos-plans')->defaults('extras', ['icon' => 'far fa-folder']);
      });
    });
  }

  public function loadUserApp()
  {
    // Auth::logout();
    // dd(get_related_routes('appuser.', ['GET']));
    return Inertia::render('dashboard/UserDashboard');
  }
}
