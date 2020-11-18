<?php

namespace App\Modules\SuperAdmin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Modules\SuperAdmin\Models\SuperAdmin;

class VerifiedSuperAdmins
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
    $superadmin = SuperAdmin::where('email', $request->email)->firstOrFail();
    if ($superadmin->is_verified()) {
      return $next($request);
    }
    return response()->json(['status' => 'Login limited'], 416);
  }
}
