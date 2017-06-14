<?php

namespace Spatie\MailableTest\Exceptions;

use Exception;

class MailableDoesNotExist extends Exception
{
    public static function withClass(string $className): self
    {
        return new self("Mailable `{$className}` doesnt exist.");
    }
}
