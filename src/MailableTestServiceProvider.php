<?php

namespace Spatie\MailableTest;

use Faker\Factory as Faker;
use Illuminate\Support\ServiceProvider;

class MailableTestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/laravel-mailable-test.php' => config_path('laravel-mailable-test.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-mailable-test.php', 'laravel-mailable-test');

        $this->registerArgumentValueProvider();
        $this->registerMailableFactory();

        $this->commands([
            SendTestMail::class,
        ]);
    }

    protected function registerArgumentValueProvider()
    {
        $this->app->singleton(ArgumentValueProvider::class, function () {
            return new FakerArgumentValueProvider(
                Faker::create()
            );
        });
    }

    protected function registerMailableFactory()
    {
        $this->app->singleton(MailableFactory::class, function () {
            $argumentValueProvider = app(
                config('laravel-mailable-test.argument_value_provider_class')
            );

            return new MailableFactory($argumentValueProvider);
        });
    }

    public function provides(): array
    {
        return ['command.mail.send.test'];
    }
}
