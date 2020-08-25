<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @param  string|null  $guard
   * @return mixed
   */
  public function handle($request, Closure $next, $guard = null)
  {
    // dd($guards);
    // foreach ($guards as $g) {
    //   dd($g);
    // }
    if (Auth::guard($guard)->check()) {
      return redirect()->route($request->user()->dashboardRoute());
    }

    return $next($request);
  }
}
