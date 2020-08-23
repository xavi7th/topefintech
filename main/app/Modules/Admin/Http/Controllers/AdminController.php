<?php

namespace App\Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Modules\Admin\Models\Admin;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\TargetType;
use App\Modules\AppUser\Models\Savings;
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Models\WithdrawalRequest;
use App\Modules\Admin\Http\Controllers\LoginController;

class AdminController extends Controller
{

  public function __construct()
  {
    Inertia::setRootView('admin::app');
  }

  public static function apiRoutes()
  {
    Route::group(['middleware' => ['api'], 'prefix' =>  Admin::DASHBOARD_ROUTE_PREFIX . '/api/',  'namespace' => '\App\Modules\Admin\Http\Controllers'], function () {
      Route::group(['middleware' => 'auth:admin_api'], function () {

        AppUser::adminApiRoutes();

        WithdrawalRequest::adminApiRoutes();
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

      Route::group(['middleware' => ['auth:admin', 'admins']], function () {
        Route::get('/', [AdminController::class, 'loadAdminApp'])->name('admin.dashboard')->defaults('extras', ['icon' => 'fa fa-tachometer-alt']);

        Admin::adminRoutes();
        AppUser::adminRoutes();
        TargetType::adminRoutes();
        Savings::adminRoutes();
        SavingsInterest::adminRoutes();
        ErrLog::routes();
      });
    });
  }

  public function loadAdminApp(Request $request)
  {
    return Inertia::render('Admin,AdminDashboard', [
      'total_savings_amount' => Savings::sum('current_balance'),
      'total_uncleared_interests_amount' => SavingsInterest::unprocessed()->sum('amount'),
      'total_cleared_interests_amount' => SavingsInterest::processed()->sum('amount')
    ]);
  }
}
