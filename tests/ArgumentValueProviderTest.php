<?php

namespace Spatie\MailableTest\Test;

use Spatie\MailableTest\ArgumentValueProvider;
use Spatie\MailableTest\Exceptions\CouldNotDetermineValue;

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

    /** @test */
    public function it_can_resolve_a_type_bound_in_the_container()
    {
        $this->app->bind('bound-type', function() {
            return 'bound-value';
        });

        $value = $this->argumentValueProvider->getValue('myBool', 'bound-type');

        $this->assertSame('bound-value', $value);
    }

    /** @test */
    public function it_can_get_a_model_instance()
    {
        TestModel::create(['name' => 'my model']);

        $value = $this->argumentValueProvider->getValue('myModel', TestModel::class);

        $this->assertInstanceOf(TestModel::class, $value);

        $this->assertEquals('my model', $value->name);
    }

    /** @test */
    public function it_will_throw_an_exception_if_an_instance_of_model_cannot_be_determined()
    {
        $this->expectException(CouldNotDetermineValue::class);

        $this->argumentValueProvider->getValue('myModel', TestModel::class);
    }
}