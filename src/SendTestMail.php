<?php

namespace Spatie\MailableTest;

use Mail;
use Exception;
use Illuminate\Console\Command;
use Validator;

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

    public function guardAgainstInvalidArguments()
    {
        $validator = Validator::make(
            ['email' => $this->argument('recipient')],
            ['email' => 'email']);

        if (! $validator->passes()) {
            throw new Exception("`{$this->argument('recipient')}` is not a valid e-mail address");
        }
    }
}
