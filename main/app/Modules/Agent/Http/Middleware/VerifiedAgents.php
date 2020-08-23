<?php

namespace App\Modules\Agent\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifiedAgents
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
    if ($request->user()->isAgent() && $request->user()->is_verified()) {
      return $next($request);
    }

    foreach (array_keys(config('auth.guards')) as $guard) {
      try {
        auth()->guard($guard)->logout();
      } catch (\Throwable $th) {
      }
    }

    if ($request->isApi()) return response()->json(['status' => 'Login limited'], 416);
    return redirect()->route('app.login')->withError('Your account is unverified');
  }
}
