<?php

namespace App\Modules\SuperAdmin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Modules\Agent\Models\Agent;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Admin;
use App\Modules\Admin\Models\ErrLog;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\AppUser\Models\InvestmentType;
use App\Modules\AppUser\Models\Savings;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\AppUser\Models\SavingsInterest;
use App\Modules\AppUser\Models\WithdrawalRequest;
use App\Modules\SuperAdmin\Http\Controllers\LoginController;

class SuperAdminController extends Controller
{
  public static function routes()
  {
    Route::group(['middleware' => 'web', 'prefix' => SuperAdmin::DASHBOARD_ROUTE_PREFIX], function () {
      LoginController::routes();

      Route::group(['middleware' => ['auth:superadmin']], function () {
        Route::get('/', [SuperAdminController::class, 'loadSuperAdminApp'])->name('superadmin.dashboard')->defaults('extras', ['icon' => 'fa fa-tachometer-alt']);

        SuperAdmin::superAdminRoutes();
        Agent::superAdminRoutes();
        AppUser::superAdminRoutes();
        Admin::superAdminRoutes();
        Savings::superAdminRoutes();
        InvestmentType::superAdminRoutes();
        SavingsInterest::superAdminRoutes();
        WithdrawalRequest::superAdminRoutes();
        ErrLog::routes();
      });
    });
  }

  public function loadSuperAdminApp(Request $request)
  {
    return Inertia::render('SuperAdmin,SuperAdminDashboard', [
      'total_savings_amount' => Savings::sum('current_balance'),
      'total_uncleared_interests_amount' => SavingsInterest::unprocessed()->sum('amount'),
      'total_cleared_interests_amount' => SavingsInterest::processed()->sum('amount')
    ]);
  }
}
