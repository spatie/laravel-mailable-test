<?php

namespace Spatie\MailableTest;

use Illuminate\Support\ServiceProvider;

class MailableTestServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/mailableTest.php' => config_path('mailableTest.php'),
            ], 'config');

            /*
            $this->loadViewsFrom(__DIR__.'/../resources/views', 'mailableTest');

            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/mailableTest'),
            ], 'views');
            */
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'mailableTest');
    }
}
