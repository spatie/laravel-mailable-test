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
    public function it_can_create_a_mailable()
    {
        $mailableClassInstance = $this->mailableFactory->getInstance(
            TestMailable::class,
            'recepient@mail.com'
        );

        $this->assertInstanceOf(TestMailable::class, $mailableClassInstance);

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
