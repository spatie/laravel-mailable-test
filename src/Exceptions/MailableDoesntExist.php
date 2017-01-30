<?php

namespace Spatie\MailableTest\Exceptions;

use Exception;

class MailableDoesntExist extends Exception
{
    public static function withClass(string $className): self
    {
        return new self("Mailable `{$className}` doesnt exist.");
    }
}
