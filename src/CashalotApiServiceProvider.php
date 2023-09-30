<?php

namespace Gavan4eg\CashalotApi;

use Illuminate\Support\ServiceProvider;

class CashalotApiServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'gavan4eg');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'gavan4eg');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/cashalot.php', 'cashalot');

        // Register the service the package provides.
        $this->app->singleton('cashalotapi', function ($app) {
            return new CashalotApi;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['cashalotapi'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/cashalot.php' => config_path('cashalot.php'),
        ], 'cashalot.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/gavan4eg'),
        ], 'cashalotapi.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/gavan4eg'),
        ], 'cashalotapi.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/gavan4eg'),
        ], 'cashalotapi.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
