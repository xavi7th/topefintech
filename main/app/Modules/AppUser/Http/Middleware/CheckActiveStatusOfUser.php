<?php

namespace App\Modules\AppUser\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckActiveStatusOfUser
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

    if (!$request->user()->is_active) {
      Session::flush();
      auth()->logout();

      if ($request->isApi()) return response()->json(['message' => 'Inactive user'], 416);
      return redirect()->route('app.login')->withFlash(['warning' => 'Account suspended. Contact support']);
    }

    return $next($request);
  }
}
