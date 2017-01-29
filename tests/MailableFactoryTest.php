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
    public function it_will_create_a_mailable_where_all_recepients_have_been_removed_and_the_given_recepient_added()
    {
        $mailableClassInstance = $this->mailableFactory->getInstance(
            TestMailable::class,
            'recepient@mail.com',
            []
        );

        $this->assertCount(1, $mailableClassInstance->to);
        $this->assertEquals('recepient@mail.com', $mailableClassInstance->to[0]['address']);
        $this->assertCount(0, $mailableClassInstance->cc);
        $this->assertCount(0, $mailableClassInstance->bcc);
    }


    /** @test */
    public function it_can_create_a_mailable_without_giving_default_values()
    {
        $mailableClassInstance = $this->mailableFactory->getInstance(
            TestMailable::class,
            'recepient@mail.com',
            []
        );

        $this->assertInstanceOf(TestMailable::class, $mailableClassInstance);

        $this->assertTrue(is_int($mailableClassInstance->myInteger));
        $this->assertTrue(is_string($mailableClassInstance->myString));
        $this->assertTrue(is_bool($mailableClassInstance->myBool));
        $this->assertInstanceOf(TestModel::class, $mailableClassInstance->myModel);
    }

    /** @test */
    public function it_can_create_a_mailable_with_the_given_default_values()
    {
        foreach(range(1,10) as $i) {
            TestModel::create(['name' => "model{$i}"]);
        }

        $mailableClassInstance = $this->mailableFactory->getInstance(
            TestMailable::class,
            'recepient@mail.com',
            [
                'myInteger' => '2',
                'myString' => 'i am a string',
                'myBool' => 'false',
                'myModel' => 6
            ]
        );

        $this->assertInstanceOf(TestMailable::class, $mailableClassInstance);

        $this->assertEquals(2, $mailableClassInstance->myInteger);
        $this->assertEquals('i am a string', $mailableClassInstance->myString);
        $this->assertFalse($mailableClassInstance->myBool);
        $this->assertInstanceOf(TestModel::class, $mailableClassInstance->myModel);
        $this->assertEquals(6, $mailableClassInstance->myModel->id);
    }

}
