<?php

namespace Spatie\MailableTest\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;

class CouldNotDetermineValue extends Exception
{
    public static function noModelInstanceFound(Model $model)
    {
        $className = get_class($model);

        return new static("Could not get a model for class `$className`");
    }
}