<?php

namespace App\Modules\SuperAdmin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use App\Modules\Admin\Http\Middleware\VerifiedSuperAdmins;

class SuperAdminServiceProvider extends ServiceProvider
{
  /**
     * @var string $moduleName
     */
    protected $moduleName = 'SuperAdmin';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'superadmin';
  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

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
    $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

    /**** Register the modules middlewares *****/
    app()->make('router')->aliasMiddleware('superadmin_verified', VerifiedSuperAdmins::class);
  }

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->app->register(RouteServiceProvider::class);
  }

  /**
   * Register config.
   *
   * @return void
   */
  protected function registerConfig()
  {
    $this->publishes([__DIR__ . '/../Config/config.php' => config_path('admin.php'),
    ], 'config');
    $this->mergeConfigFrom(
      __DIR__ . '/../Config/config.php',
      'superadmin'
    );
  }

  /**
   * Register views.
   *
   * @return void
   */
  public function registerViews()
  {
    $viewPath = resource_path('views/modules/superadmin');

    $sourcePath = __DIR__ . '/../Resources/views';

    $this->publishes([
      $sourcePath => $viewPath
    ], 'views');

    $this->loadViewsFrom(array_merge(array_map(function ($path) {
      return $path . '/modules/admin';
    }, \Config::get('view.paths')), [$sourcePath]), 'superadmin');
  }

  /**
   * Register translations.
   *
   * @return void
   */
  public function registerTranslations()
  {
    $langPath = resource_path('lang/modules/superadmin');

    if (is_dir($langPath)) {
      $this->loadTranslationsFrom($langPath, 'superadmin');
    } else {
      $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'superadmin');
    }
  }

  /**
   * Register an additional directory of factories.
   *
   * @return void
   */
  public function registerFactories()
  {
    if (!app()->environment('production')) {
      app(Factory::class)->load(__DIR__ . '/../Database/factories');
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
