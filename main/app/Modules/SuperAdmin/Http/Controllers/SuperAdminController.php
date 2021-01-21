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
use App\Modules\AppUser\Models\Transaction;
use App\Modules\AppUser\Models\WithdrawalRequest;
use App\Modules\BasicSite\Models\SiteContent;
use App\Modules\BasicSite\Models\Testimonial;
use App\Modules\SuperAdmin\Http\Controllers\LoginController;

class SuperAdminController extends Controller
{
  public static function routes()
  {
    Route::group(['middleware' => 'web', 'prefix' => SuperAdmin::DASHBOARD_ROUTE_PREFIX], function () {
      LoginController::routes();

      Route::group(['middleware' => ['auth:superadmin']], function () {
        Route::get('/', [self::class, 'loadSuperAdminApp'])->name('superadmin.dashboard')->defaults('extras', ['icon' => 'fa fa-tachometer-alt']);

        Agent::superAdminRoutes();
        AppUser::superAdminRoutes();
        Admin::superAdminRoutes();
        Savings::superAdminRoutes();
        InvestmentType::superAdminRoutes();
        SavingsInterest::superAdminRoutes();
        SuperAdmin::superAdminRoutes();
        WithdrawalRequest::superAdminRoutes();
        SiteContent::superAdminRoutes();
        Testimonial::superAdminRoutes();
        ErrLog::routes();
      });
    });
  }

  public function loadSuperAdminApp(Request $request)
  {
    return Inertia::render('SuperAdmin,SuperAdminDashboard', [
      'total_savings_amount' => (float) Savings::sum('current_balance'),
      'total_smart_savings_amount' => (float) Savings::smart()->sum('current_balance'),
      'total_target_savings_amount' => (float) Savings::target()->sum('current_balance'),
      'total_investment_savings_amount' => (float) Savings::investment()->sum('current_balance'),
      'total_uncleared_interests_amount' => (float) SavingsInterest::unprocessed()->sum('amount'),
      'total_cleared_interests_amount' => (float) SavingsInterest::processed()->sum('amount'),
      'total_daily_credits' => (float) Transaction::deposits()->today()->sum('amount'),
      'total_daily_payouts' => (float) Transaction::withdrawals()->today()->sum('amount'),
      'total_users' => (int) AppUser::count(),
      'total_independent_users' => (int) AppUser::whereAgentId(null)->count(),
    ]);
  }
}
