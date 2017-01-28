<?php

namespace Spatie\MailableTest\Test;

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

        TestModel::create(['name' => 'my name']);

        $this->mailableFactory = app(MailableFactory::class);
    }

    /** @test */
    public function it_test()
    {
        $mailableClass = new class extends BaseMailable
        {
            /** @var int */
            public $myInteger = null;

            /**  @var string */
            public $myString = null;

            /**  @var bool */
            public $myBool = null;

            /**  @var TestModel */
            public $myModel = null;

            public function __construct(
                int $myInteger = null,
                string $myString = null,
                bool $myBool = null,
                TestModel $myModel = null
            )
            {
                $this->myInteger = $myInteger;
                $this->myString = $myString;
                $this->myBool = $myBool;
                $this->myModel = $myModel;
            }
        };

        $mailableClassInstance = $this->mailableFactory->getInstance(
            get_class($mailableClass),
            'recepient@mail.com'
        );

        $this->assertInstanceOf(get_class($mailableClass), $mailableClassInstance);
        $this->assertTrue(is_int($mailableClassInstance->myInteger));
        $this->assertTrue(is_string($mailableClassInstance->myString));
        $this->assertTrue(is_bool($mailableClassInstance->myBool));
        $this->assertInstanceOf(TestModel::class, $mailableClassInstance->myModel);

        $this->assertCount(1, $mailableClassInstance->to);
        $this->assertEquals('recepient@mail.com', $mailableClassInstance->to[0]['address']);
        $this->assertCount(0, $mailableClassInstance->cc);
        $this->assertCount(0, $mailableClassInstance->bcc);
    }
}
