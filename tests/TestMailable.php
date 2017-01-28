<?php

namespace Spatie\MailableTest\Test;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestMailable extends Mailable
{
    /** @var int */
    public $myInteger;

    /**  @var string */
    public $myString;

    /**  @var bool */
    public $myBool;

    /**  @var TestModel */
    public $myModel;

    public function __construct(
        int $myInteger,
        string $myString,
        bool $myBool,
        TestModel $myModel
    )
    {
        $this->myInteger = $myInteger;
        $this->myString = $myString;
        $this->myBool = $myBool;
        $this->myModel = $myModel;
    }

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
