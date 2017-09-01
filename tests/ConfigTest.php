<?php

namespace Spatie\MailableTest\Test;

use Mail;
use Artisan;
use Spatie\MailableTest\Exceptions\InvalidConfiguration;

class ConfigTest extends TestCase
{
    /** @test */
    public function it_will_throw_an_exception_if_argument_value_provider_class_contains_an_invalid_class()
    {
        $this->expectException(InvalidConfiguration::class);

        $this->app['config']->set('mailable-test.argument_value_provider_class', '');

        Artisan::call('mail:send-test', [
            'mailableClass' => TestMailable::class,
            'recipient' => 'test@mail.com',
        ]);
    }
}
