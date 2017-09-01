<?php

namespace Spatie\MailableTest\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function invalidValueProviderClass($argumentValueProviderClass)
    {
        $expectedClass = ArgumentValueProvider::class;

        return new static("The `argument_value_provider_class` option in the config file expect a class that is a `{$expectedClass}` but a `{$argumentValueProviderClass}` was given.");
    }
}
