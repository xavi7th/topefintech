<?php

namespace App\Modules\BasicSite\Providers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Http\Request;

class BasicSiteServiceProvider extends ServiceProvider
{
  /**
   * Boot the application events.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerTranslations();
    $this->registerConfig();
    $this->registerViews();
    $this->registerFactories();
    $this->loadMigrationsFrom(module_path('BasicSite', 'Database/Migrations'));
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->app->register(RouteServiceProvider::class);
    $this->registerInertia();
  }



  public function registerInertia()
  {
    Inertia::version(function () {
      return md5_file(public_path('mix-manifest.json'));
    });

    Inertia::share([
      'app' => [
        'name' => config('app.name'),
        'whatsapp' => config('app.whatsapp'),
        'address' => config('app.address'),
        'phone' => config('app.phone'),
        'email' => config('app.email'),
      ],
      'routes' => function (Request $request) {
        return optional($request->user())->get_navigation_routes() ?? [];
      },
      'isInertiaRequest' => request()->header('X-Inertia'),
      'auth' => function () {
        return [
          'user' => Auth::user() ? Auth::user() : (object)[],
        ];
      },
      'flash' => function () {
        return [
          'success' => Session::get('success'),
          'error' => Session::get('error'),
        ];
      },
      'errors' => function () {
        return Session::get('errors')
          ? Session::get('errors')->getBag('default')->getMessages()
          : (object)[];
      },
    ]);
  }


  /**
   * Register config.
   *
   * @return void
   */
  protected function registerConfig()
  {
    $this->publishes([
      module_path('BasicSite', 'Config/config.php') => config_path('basicsite.php'),
    ], 'config');
    $this->mergeConfigFrom(
      module_path('BasicSite', 'Config/config.php'),
      'basicsite'
    );
  }

  /**
   * Register views.
   *
   * @return void
   */
  public function registerViews()
  {
    $viewPath = resource_path('views/modules/basicsite');

    $sourcePath = module_path('BasicSite', 'Resources/views');

    $this->publishes([
      $sourcePath => $viewPath
    ], 'views');

    $this->loadViewsFrom(array_merge(array_map(function ($path) {
      return $path . '/modules/basicsite';
    }, \Config::get('view.paths')), [$sourcePath]), 'basicsite');
  }

  /**
   * Register translations.
   *
   * @return void
   */
  public function registerTranslations()
  {
    $langPath = resource_path('lang/modules/basicsite');

    if (is_dir($langPath)) {
      $this->loadTranslationsFrom($langPath, 'basicsite');
    } else {
      $this->loadTranslationsFrom(module_path('BasicSite', 'Resources/lang'), 'basicsite');
    }
  }

  /**
   * Register an additional directory of factories.
   *
   * @return void
   */
  public function registerFactories()
  {
    if (!app()->environment('production') && $this->app->runningInConsole()) {
      app(Factory::class)->load(module_path('BasicSite', 'Database/factories'));
    }
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return [];
  }
}
