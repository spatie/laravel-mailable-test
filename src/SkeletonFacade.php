<?php

namespace Spatie\MailableTest;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\MailableTest\MailableTestClass
 */
class MailableTestFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mailableTest';
    }
}
