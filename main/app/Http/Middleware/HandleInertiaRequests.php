<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HandleInertiaRequests extends Middleware
{
  /**
   * The root template that's loaded on the first page visit.
   *
   * @see https://inertiajs.com/server-side-setup#root-template
   * @var string
   */
  protected $rootView = 'basicsite::app';

  /**
   * Determines the current asset version.
   *
   * @see https://inertiajs.com/asset-versioning
   * @param  \Illuminate\Http\Request  $request
   * @return string|null
   */
  public function version(Request $request)
  {
    return parent::version($request);
  }

  /**
   * Defines the props that are shared by default.
   *
   * @see https://inertiajs.com/shared-data
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function share(Request $request)
  {
    return array_merge(parent::share($request), [
      'app' => fn() => [
        'name' => config('app.name'),
        'whatsapp' => config('app.whatsapp'),
        'address' => config('app.address'),
        'phone' => config('app.phone'),
        'email' => config('app.email'),
        'facebook' => config('app.facebook'),
        'instagram' => config('app.instagram'),
        'twitter' => config('app.twitter'),
        'opening_days' => config('app.opening_days'),
        'opening_hours' => config('app.opening_hours'),
      ],
      'routes' => function (Request $request) {
        return $request->route() ? (Str::of($request->route()->getName())->before('.')->is('app') ? get_related_routes('app.', ['GET']) : optional($request->user())->get_navigation_routes() ?? []) : (object)[];
      },
      'isInertiaRequest' => (bool)request()->header('X-Inertia'),
      'auth' => function (Request $request) {
        return [
          'user' => Auth::user() ? $request->user()->getDetails() : (object)[],
          'notification_count' => Auth::user() ? $request->user()->unreadNotifications()->count() : null
        ];
      },
      'flash' => fn () => Session::get('flash') ?? (object)[],
    ]);
  }

  /**
   * Sets the root template that's loaded on the first page visit.
   *
   * @see https://inertiajs.com/server-side-setup#root-template
   * @param Request $request
   * @return string
   */
  public function rootView(Request $request):string
  {
    if ($request->user()) {
      return strtolower($request->user()->getType()) . '::app';
    } elseif (Str::containsAll(\Route::currentRouteName(), ['super', 'admin', 'login'])) {
      return 'superadmin::app';
    } elseif (Str::containsAll(\Route::currentRouteName(), ['admin', 'login'])) {
      return 'admin::app';
    } elseif (Str::contains(\Route::currentRouteName(), ['login', 'register'])) {
      return 'appuser::app';
    } else {
      return $this->rootView;
    }
  }
}
