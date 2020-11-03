<?php

namespace App\Modules\AppUser\Http\Controllers;


use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
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
use App\Modules\AppUser\Transformers\SavingsRecordTransformer;
use RachidLaasri\Travel\Travel;

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


      Route::group(['middleware' => ['throttle:20,1', 'auth', 'verified_users'], 'prefix' => AppUser::DASHBOARD_ROUTE_PREFIX], function () {

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
    Travel::to('4 months 4 days');
    return Inertia::render('AppUser,dashboard/UserDashboard', [
      'userSavings' => function () use ($request) {
        return (new SavingsRecordTransformer)->collectionTransformer($request->user()->savings_list()->active()->with('target_type')->get(), 'forUserDashboard');
      },
      'userInvestments' => function () use ($request) {
        return [];
      },
      'liquidatedSavings' => function () use ($request) {
        return (new SavingsRecordTransformer)->collectionTransformer($request->user()->savings_list()->liquidated()->get(), 'forLiquidatedVault');
      },
      'maturedSavings' => function () use ($request) {
        return (new SavingsRecordTransformer)->collectionTransformer($request->user()->savings_list()->matured()->get(), 'forUserDashboard');
      },
    ]);
  }
}
