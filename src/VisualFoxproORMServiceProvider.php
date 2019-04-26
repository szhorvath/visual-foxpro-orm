<?php

namespace Szhorvath\VisualFoxproORM;

use Illuminate\Support\ServiceProvider;

class VisualFoxproORMServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'szhorvath');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'szhorvath');
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
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/visualfoxproorm.php', 'visualfoxproorm');

        // Register the service the package provides.
        $this->app->singleton('visualfoxproorm', function ($app) {
            return new VisualFoxproORM;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['visualfoxproorm'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/visualfoxproorm.php' => config_path('visualfoxproorm.php'),
        ], 'visualfoxproorm.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/szhorvath'),
        ], 'visualfoxproorm.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/szhorvath'),
        ], 'visualfoxproorm.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/szhorvath'),
        ], 'visualfoxproorm.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
