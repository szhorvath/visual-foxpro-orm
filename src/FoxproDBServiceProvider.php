<?php

namespace Szhorvath\FoxproDB;

use Szhorvath\FoxproDB\FoxproDB;
use Illuminate\Support\ServiceProvider;

class FoxproDBServiceProvider extends ServiceProvider
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
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
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
        $this->mergeConfigFrom(__DIR__ . '/../config/foxprodb.php', 'foxprodb');

        // Register the service the package provides.
        $this->app->bind('foxprodb', function ($app) {
            return new FoxproDB(config('foxprodb'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['foxprodb'];
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
            __DIR__ . '/../config/foxprodb.php' => config_path('foxprodb.php'),
        ], 'foxprodb.config');

        // Publishing the migration file.
        $this->publishes([
            __DIR__ . '/../database/migrations/audits.stub' => database_path(
                sprintf('migrations/%s_create_foxpro_audits_table.php', date('Y_m_d_His'))
            ),
        ], 'migrations');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/szhorvath'),
        ], 'foxprodb.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/szhorvath'),
        ], 'foxprodb.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/szhorvath'),
        ], 'foxprodb.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
