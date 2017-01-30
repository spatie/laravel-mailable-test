<?php

namespace Spatie\MailableTest;

interface ArgumentValueProvider
{
    /**
     * @param string $mailableClass
     * @param string $argumentName
     * @param string $argumentType
     * @param string|null $defaultValue
     *
     * @return mixed
     */
    public function getValue(string $mailableClass, string $argumentName, string $argumentType = '', $defaultValue = null);
}
