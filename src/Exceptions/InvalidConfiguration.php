<?php

namespace Spatie\MailableTest\Exceptions;

use Exception;
use Spatie\MailableTest\ArgumentValueProvider;

class InvalidConfiguration extends Exception
{
    public static function invalidValueProviderClass(string $className)
    {
        return new static("The `argument_value_provider_class` config value is invalid. Given class `{$className}` does not extend `".ArgumentValueProvider::class.'`.');
    }
}
