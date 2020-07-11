<?php

namespace App\Modules\AppUser\Http\Controllers;


use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\TargetType;
use App\Modules\AppUser\Models\Savings;
use App\Modules\AppUser\Models\DebitCard;
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

        Savings::appUserRoutes();

        SavingsInterest::appUserRoutes();

        DebitCard::appUserRoutes();

        WithdrawalRequest::appUserRoutes();

        TargetType::appUserRoutes();

        Transaction::appUserRoutes();

        AppUser::routes();

        // Route::get('messages', [self::class, 'loadUserApp'])->name('appuser.messages')->defaults('extras', ['icon' => 'fas fa-mail-bulk']);
      });
    });
  }

  public function loadDashboard(Request $request)
  {
    return Inertia::render('dashboard/UserDashboard', [
      'total_savings_amount' =>  $request->user()->total_deposit_amount(),
      'total_smart_savings_amount' => $request->user()->total_withdrawable_amount(),
      'interest_today' =>  $request->user()->daily_interest(),
      'total_interests_amount' =>  $request->user()->total_interests_amount(),
      'total_uncleared_interests_amount' => $request->user()->savings_interests()->uncleared()->sum('amount'),
      'total_withdrawals_amount' =>  $request->user()->total_withdrawal_amount(),
    ]);
  }
}
