<?php

namespace App\Modules\Agent\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAgentActiveStatus
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    if ($request->user()->isAgent() && $request->user()->is_active) {
      return $next($request);
    }

    foreach (array_keys(config('auth.guards')) as $guard) {
      try {
        auth()->guard($guard)->logout();
      } catch (\Throwable $th) {
      }
    }

    return redirect()->route('app.login')->withFlash(['warning' => 'Your account has been suspended. Contact support.']);
  }
}
