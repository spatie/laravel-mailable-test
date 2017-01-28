<?php

namespace Spatie\MailableTest\Test;

use Spatie\MailableTest\MailableFactory;

class MailableFactoryTest extends TestCase
{
    /** @test */
    public function it_test()
    {
        $mailableClass = new class extends BaseMailable {

            public $int = 0;

            public function __construct(int $integer = 0)
            {
                $this->int = $integer;
            }
        };
    }
}
