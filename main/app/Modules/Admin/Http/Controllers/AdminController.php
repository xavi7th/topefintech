<?php

namespace App\Modules\Admin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Modules\Admin\Models\Admin;
use App\Modules\Agent\Models\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\Savings;
use App\Modules\AppUser\Models\TargetType;
use App\Modules\AppUser\Models\InvestmentType;
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Models\WithdrawalRequest;
use App\Modules\Admin\Http\Controllers\LoginController;

class AdminController extends Controller
{
  public static function apiRoutes()
  {
    Route::group(['middleware' => ['api'], 'prefix' =>  Admin::DASHBOARD_ROUTE_PREFIX . '/api/',  'namespace' => '\App\Modules\Admin\Http\Controllers'], function () {
      Route::group(['middleware' => 'auth:admin_api'], function () {

        AppUser::adminApiRoutes();


      });
    });
  }

  /**
   * The admin routes
   * @return Response
   */
  public static function routes()
  {
    Route::group(['middleware' => 'web', 'prefix' => Admin::DASHBOARD_ROUTE_PREFIX, 'namespace' => 'App\\Modules\Admin\Http\Controllers'], function () {

      LoginController::routes();

      Route::group(['middleware' => ['auth:admin', 'is_admin_active']], function () {
        Route::get('/', [self::class, 'loadAdminApp'])->name('admin.dashboard')->defaults('extras', ['icon' => 'fa fa-tachometer-alt']);

        Admin::adminRoutes();
        Agent::adminRoutes();
        AppUser::adminRoutes();
        TargetType::adminRoutes();
        Savings::adminRoutes();
        SavingsInterest::adminRoutes();
        WithdrawalRequest::adminRoutes();

      });
    });
  }

  public function loadAdminApp(Request $request)
  {
    return Inertia::render('Admin,AdminDashboard', [
      'totalTransactions' => (int) $request->user()->wallet_transactions()->withdrawals()->count(),
      'walletBalance' => (float) $request->user()->wallet_balance,
      'dailySmartSavingsAmount' => (float)Savings::smart()->today()->sum('current_balance'),
      'dailyTargetSavingsAmount' => (float)Savings::target()->today()->sum('current_balance'),
      'matureSavingsCount' => (int)Savings::matured()->notWithdrawn()->count(),
      'dailyAgentSignupCount' => (int) AppUser::whereDate('created_at', today())->where('agent_id', '<>', null)->count(),
    ]);
  }
}
