<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
  /**
   * Indicates whether the XSRF-TOKEN cookie should be set on the response.
   *
   * @var bool
   */
  protected $addHttpCookie = true;

  /**
   * The URIs that should be excluded from CSRF verification.
   *
   * @var array
   */
  protected $except = [
    //
  ];



  /**
   * Determine if the request has a URI that should pass through CSRF verification.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return bool
   */
  protected function inExceptArray($request)
  {
    foreach ($this->except as $except) {
      if ($except !== '/') {
        $except = trim($except, '/');
      }

      if ($request->fullUrlIs($except) || $request->is($except)) {
        return true;
      }
    }


    if (app()->environment('local') && $request->header('postman-token')) {
      return true;
    }

    return false;
  }
}
