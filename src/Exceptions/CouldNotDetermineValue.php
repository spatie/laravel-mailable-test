<?php

namespace Spatie\MailableTest\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;

class CouldNotDetermineValue extends Exception
{
    public static function create($argumentType, $argumentName, Exception $exception): self
    {
        return new self("Could not determine a value of type `{$argumentType}` for argument with name `{$argumentName}`", null, $exception);
    }

    public static function noModelInstanceFound(Model $model): self
    {
        $className = get_class($model);

        return new self("Could not get a model for class `$className`");
    }
}
