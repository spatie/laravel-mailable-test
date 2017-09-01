<?php

namespace Spatie\MailableTest;

use Faker\Factory as Faker;
use Illuminate\Support\ServiceProvider;
use Spatie\MailableTest\Exceptions\InvalidConfiguration;

class MailableTestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/mailable-test.php' => config_path('mailable-test.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/mailable-test.php', 'mailable-test');

        $this->app->bind(MailableFactory::class, function () {
            $argumentValueProviderClass = config('mailable-test.argument_value_provider_class');

            if (! is_a($argumentValueProviderClass, ArgumentValueProvider::class, true)) {
                throw InvalidConfiguration::invalidValueProviderClass($argumentValueProviderClass);
            }

            $argumentValueProvider = app($argumentValueProviderClass);

            return new MailableFactory($argumentValueProvider);
        });

        $this->app->bind(ArgumentValueProvider::class, function () {
            $argumentValueProvider = config('mailable-test.argument_value_provider_class');

            return new $argumentValueProvider(
                Faker::create()
            );
        });

        $this->commands([
            SendTestMail::class,
        ]);
    }

    public function provides(): array
    {
        return ['command.mail.send.test'];
    }
}
