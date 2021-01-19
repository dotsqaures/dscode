<?php

namespace Modules\AdminUserManager\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Auth;

class AdminUserManagerServiceProvider extends ServiceProvider
{
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
        $this->registerComposerViews();
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
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('adminusermanager.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'adminusermanager'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/adminusermanager');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/adminusermanager';
        }, \Config::get('view.paths')), [$sourcePath]), 'adminusermanager');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/adminusermanager');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'adminusermanager');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'adminusermanager');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
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

    public function registerComposerViews()
    {
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $view->with('adminUser', Auth::guard('admin')->user());
        });

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $action = app('request')->route() ? app('request')->route()->getAction() : '';
                if(isset($action['controller'])){
                    $controller = class_basename($action['controller']);
                    list($controller, $action) = explode('@', $controller);
                    $view->with(['getController' => str_replace('Controller', '', $controller),'getAction' => $action]);
                }

        });

    }


}
