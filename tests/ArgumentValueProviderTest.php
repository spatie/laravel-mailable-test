<?php

namespace Spatie\MailableTest\Test;

use Spatie\MailableTest\ArgumentValueProvider;

class ArgumentValueProviderTest extends TestCase
{
    /** @var \Spatie\MailableTest\ArgumentValueProvider */
    protected $argumentValueProvider;

    public function setUp()
    {
        parent::setUp();

        $this->argumentValueProvider = app(ArgumentValueProvider::class);
    }

    /** @test */
    public function it_can_generate_a_string()
    {
        $value = $this->argumentValueProvider->getValue('myString', 'string');

        $this->assertTrue(is_string($value));
    }

    /** @test */
    public function it_can_generate_an_integer()
    {
        $value = $this->argumentValueProvider->getValue('myInt', 'int');

        $this->assertTrue(is_int($value));
    }

    /** @test */
    public function it_can_generate_a_boolean()
    {
        $value = $this->argumentValueProvider->getValue('myBool', 'bool');

        $this->assertTrue(is_bool($value));
    }
}