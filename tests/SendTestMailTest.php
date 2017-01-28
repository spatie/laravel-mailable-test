<?php

namespace Spatie\MailableTest\Test;

use Exception;
use Mail;
use Artisan;

class SendTestMailTest extends TestCase
{
    /** @test */
    public function it_can_send_a_mail()
    {
        Mail::fake();

        TestModel::create(['name' => 'my name']);

        Artisan::call('mail:send-test', [
           'mailableClass' => TestMailable::class,
           'recipient' => 'recepient@mail.com'
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
    public function it_will_throw_an_exception_when_passing_an_invalid_mail_address()
    {
        $this->expectException(Exception::class);

        Artisan::call('mail:send-test', [
            'mailableClass' => TestMailable::class,
            'recipient' => 'invalid-mail-address'
        ]);
    }
}
