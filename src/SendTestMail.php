<?php

namespace Spatie\MailableTest;

use Mail;
use Exception;
use Illuminate\Console\Command;

class SendTestMail extends Command
{
    protected $signature = 'mail:send-test {mailableClass} {recipient}';

    protected $description = 'Send a test email';

    public function handle()
    {
        $this->guardAgainstInvalidArguments();

        $mailable = app(MailableFactory::class)->getInstance(
            $this->argument('mailableClass'),
            $this->argument('recipient')
        );

        Mail::send($mailable);

        $this->comment('Mail sent!');
    }

    public function guardAgainstInvalidArguments(): void
    {
        if (! validate($this->argument('recipient'), 'email')) {
            throw new Exception("`{$this->argument('recipient')}` is not a valid e-mail address");
        }
    }
}
