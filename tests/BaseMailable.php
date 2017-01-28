<?php

namespace Spatie\MailableTest\Test;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class BaseMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to('client@mail.com')
            ->replyTo('replyto@mail.com')
            ->cc('cc@mail.com')
            ->bcc('bcc@mail.com')
            ->subject('test mailable')
            ->markdown('mail.dummy');
    }
}
