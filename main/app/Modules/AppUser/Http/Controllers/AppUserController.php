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

  /**
   * @return Response
   */
  public static function routes()
  {
    Route::group(['middleware' => 'web', 'namespace' => '\App\Modules\AppUser\Http\Controllers'], function () {
      LoginController::routes();
      RegisterController::routes();
      // ResetPasswordController::routes();
      // ForgotPasswordController::routes();
      // ConfirmPasswordController::routes();
      VerificationController::routes();


      Route::group(['middleware' => ['throttle:20,1', 'auth', 'email_verified', 'appusers'], 'prefix' => AppUser::DASHBOARD_ROUTE_PREFIX], function () {

        Route::redirect('/', '/user/dashboard', 303);
        Route::get('dashboard', [self::class, 'loadDashboard'])->name('appuser.dashboard')->defaults('extras', ['icon' => 'fas fa-desktop']);

        AppUser::routes();

        Savings::appUserRoutes();

        LoanRequest::appUserRoutes();

        SavingsInterest::appUserRoutes();

        DebitCard::appUserRoutes();

        WithdrawalRequest::appUserRoutes();

        GOSType::appUserRoutes();

        LoanSurety::appUserRoutes();

        Transaction::appUserRoutes();

        ErrLog::routes();

        Route::get('statement', [self::class, 'loadUserApp'])->name('appuser.statement')->defaults('extras', ['icon' => 'far fa-file-alt']);
        Route::get('messages', [self::class, 'loadUserApp'])->name('appuser.messages')->defaults('extras', ['icon' => 'fas fa-mail-bulk']);
      });
    });
  }

  public function loadDashboard()
  {
    cache()->flush();
    return Inertia::render('dashboard/UserDashboard');
  }
}
