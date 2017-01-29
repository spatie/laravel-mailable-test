<?php

namespace Spatie\MailableTest\Test;

use InvalidArgumentException;
use Mail;
use Artisan;
use Exception;

class SendTestMailTest extends TestCase
{
    /** @test */
    public function it_can_send_a_mail_without_passing_values()
    {
        Mail::fake();

        TestModel::create(['name' => 'my name']);

        Artisan::call('mail:send-test', [
           'mailableClass' => TestMailable::class,
           'recipient' => 'recepient@mail.com',
        ]);

        Mail::assertSent(TestMailable::class, function (TestMailable $mail) {
            $this->assertCount(1, $mail->to);
            $this->assertEquals('recepient@mail.com', $mail->to[0]['address']);
            $this->assertCount(0, $mail->cc);
            $this->assertCount(0, $mail->bcc);

            return true;
        });
    }

    /** @test */
    public function it_can_send_a_mail_with_passing_values()
    {
        Mail::fake();

        TestModel::create(['name' => 'my name']);

        Artisan::call('mail:send-test', [
            'mailableClass' => TestMailable::class,
            'recipient' => 'recepient@mail.com',
            '--values' => 'myInteger:5,myBool:true,myString:my-string',
        ]);

        Mail::assertSent(TestMailable::class, function (TestMailable $mail) {
            $mail->myInteger = 5;
            $mail->myBool = true;
            $mail->myString = 'my-string';
            $this->assertCount(1, $mail->to);
            $this->assertEquals('recepient@mail.com', $mail->to[0]['address']);
            $this->assertCount(0, $mail->cc);
            $this->assertCount(0, $mail->bcc);

            return true;
        });
    }

    /** @test */
    public function it_will_throw_an_exception_when_passing_an_invalid_mail_address()
    {
        $this->expectException(Exception::class);

        Artisan::call('mail:send-test', [
            'mailableClass' => TestMailable::class,
            'recipient' => 'invalid-mail-address',
        ]);
    }

    /** @test */
    public function it_will_throw_an_exception_when_passing_invalid_values()
    {
        $this->expectException(InvalidArgumentException::class);

        Artisan::call('mail:send-test', [
            'mailableClass' => TestMailable::class,
            'recipient' => 'recepient@mail.com',
            '--values' => 'myInteger',
        ]);
    }
}
