<?php

namespace App\Http\Middleware;

use Closure;
use Inertia\Inertia;
use Illuminate\Support\Str;
use RachidLaasri\Travel\Travel;

class RegisterInertiaView
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle($request, Closure $next)
  {
    // Travel::to('12 months 1 day');
    // dump(\Route::currentRouteName());
    // dd(routeHasRootNamespace('app.'));
    if ($request->user()) {
      Inertia::setRootView(strtolower($request->user()->getType()) . '::app');
    } elseif (Str::containsAll(\Route::currentRouteName(), ['admin', 'login'])) {
      Inertia::setRootView('admin::app');
    } elseif (Str::contains(\Route::currentRouteName(), ['login', 'register'])) {
      Inertia::setRootView('appuser::app');
    } else {
      Inertia::setRootView('basicsite::app');
    }
    return $next($request);
  }
}
