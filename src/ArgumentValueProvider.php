<?php

namespace Spatie\MailableTest;

interface ArgumentValueProvider
{
    public function getValue($argumentName, $argumentType);
}
