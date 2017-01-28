<?php

namespace Spatie\MailableTest\Test;

use Mockery;
use Spatie\MailableTest\ArgumentValueProvider;
use Spatie\MailableTest\MailableFactory;

class MailableFactoryTest extends TestCase
{
    /** @var \Spatie\MailableTest\ArgumentValueProvider|\Mockery\MockInterface */
    protected $argumentValueProvider;

    /** @var \Spatie\MailableTest\MailableFactory */
    protected $mailableFactory;

    public function setUp()
    {
        parent::setUp();

        $this->argumentValueProvider = Mockery::mock(ArgumentValueProvider::class);

        $this->mailableFactory = new MailableFactory($this->argumentValueProvider);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    /** @test */
    public function it_test()
    {
        $mailableClass = new class extends BaseMailable
        {
            public $int = 0;

            public function __construct(int $integer = 0)
            {
                $this->int = $integer;
            }
        };

        $this->argumentValueProvider
            ->shouldReceive('getValue')
            ->withArgs(['integer', 'int'])
            ->once()
            ->andReturn('1');

        $this->mailableFactory->getInstance(get_class($mailableClass));
    }
}
