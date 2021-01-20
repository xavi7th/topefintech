<?php

namespace App\Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminActiveStatus
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
    if ($request->user()->isAdmin() && $request->user()->is_active) {
      return $next($request);
    }

    foreach (array_keys(config('auth.guards')) as $guard) {
      try {
        auth()->guard($guard)->logout();
      } catch (\Throwable $th) {
      }
    }

    return redirect()->route('admin.login.show')->withFlash(['warning' => 'Your account has been suspended. Contact support.']);
  }
}
