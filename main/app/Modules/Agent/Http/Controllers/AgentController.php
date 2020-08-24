<?php

namespace App\Modules\Agent\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\Agent\Models\Agent;
use Illuminate\Support\Facades\Route;

class AgentController extends Controller
{
  public function __construct()
  {
    Inertia::setRootView('agent::app');
  }

  /**
   * The agent routes
   * @return Response
   */
  public static function routes()
  {
    Route::group(['middleware' => 'web', 'prefix' => Agent::DASHBOARD_ROUTE_PREFIX, 'namespace' => 'App\\Modules\Agent\Http\Controllers'], function () {
      Route::group(['middleware' => ['auth:agent', 'verified_agents']], function () {
        Route::get('/', [self::class, 'loadAgentApp'])->name('agent.dashboard')->defaults('extras', ['icon' => 'fa fa-tachometer-alt']);

        Agent::agentRoutes();
      });
    });
  }

  public function loadAgentApp(Request $request)
  {
    return Inertia::render('Agent,AgentDashboard', [
      'totalClients' => $request->user()->managed_users()->count(),
      'totalTransactions' => $request->user()->agent_wallet_transactions()->withdrawals()->count(),
      'latestNotifications' => $request->user()->notifications()->latest()->take(3)->get()
    ]);
  }
}
