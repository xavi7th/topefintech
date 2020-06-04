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


      Route::group(['middleware' => ['auth', 'email_verified', 'appusers'], 'prefix' => AppUser::DASHBOARD_ROUTE_PREFIX], function () {

        AppUser::routes();

        Route::redirect('/', '/user/dashboard', 303);
        Route::get('dashboard', 'AppUserController@loadDashboard')->name('appuser.dashboard')->defaults('extras', ['icon' => 'fas fa-desktop']);
        Route::get('savings', 'AppUserController@viewUserSavings')->name('appuser.savings')->defaults('extras', ['icon' => 'fas fa-wallet']);
        Route::get('savings/get-distribution-details', 'AppUserController@getSavingsDistribution')->name('appuser.savings.distribution')->defaults('extras', ['nav_skip' => true]);
        Route::get('statement', 'AppUserController@loadUserApp')->name('appuser.statement')->defaults('extras', ['icon' => 'far fa-file-alt']);
        Route::get('request-smart-loan', 'AppUserController@showRequestSmartLoanForm')->name('appuser.smart-loan')->defaults('extras', ['icon' => 'fas fa-dollar-sign']);
        Route::get('smart-loan-logs', 'AppUserController@viewSmartLoans')->name('appuser.smart-loan.logs')->defaults('extras', ['nav_skip' => true]);
        Route::get('smart-loan-details', 'AppUserController@viewSmartLoanDetails')->name('appuser.smart-loan.details')->defaults('extras', ['nav_skip' => true]);
        Route::get('make-withdrawals', 'AppUserController@loadUserApp')->name('appuser.withdraw')->defaults('extras', ['icon' => 'fas fa-money-bill-wave']);
        Route::get('smart-interests', 'AppUserController@loadUserApp')->name('appuser.smart-interest')->defaults('extras', ['icon' => 'fas fa-money-check-alt']);
        Route::get('my-cards', 'AppUserController@viewDebitCards')->name('appuser.my-cards')->defaults('extras', ['icon' => 'far fa-credit-card']);

        Route::get('messages', 'AppUserController@loadUserApp')->name('appuser.messages.')->defaults('extras', ['icon' => 'fas fa-mail-bulk']);
        Route::get('gos-funds/create', 'AppUserController@initialiseGOSFund')->name('appuser.create-gos-plan')->defaults('extras', ['icon' => 'far fa-folder']);
      });
    });
  }

  public function loadDashboard()
  {
    return Inertia::render('dashboard/UserDashboard');
  }

  public function viewUserSavings()
  {
    return Inertia::render('savings/UserSavings', [
      'savings' => auth()->user()->savings_list
    ]);
  }

  public function getSavingsDistribution()
  {
    return Inertia::render('savings/GetSavingsDistribution');
  }

  public function initialiseGOSFund()
  {
    return Inertia::render('savings/CreateGOSPlan');
  }

  public function viewDebitCards()
  {
    return Inertia::render('savings/DebitCards');
  }

  public function showRequestSmartLoanForm()
  {
    return Inertia::render('loans/RequestSmartLoan');
  }

  public function viewSmartLoans()
  {
    return Inertia::render('loans/ViewSmartLoans');
  }

  public function viewSmartLoanDetails()
  {
    return Inertia::render('loans/ViewSmartLoanDetails');
  }
}
