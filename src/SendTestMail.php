<?php

namespace Spatie\MailableTest;

use InvalidArgumentException;
use Mail;
use Exception;
use Validator;
use Illuminate\Console\Command;

class SendTestMail extends Command
{
    protected $signature = 'mail:send-test {mailableClass} {recipient} {--values=}';

    protected $description = 'Send a test email';

    public function handle()
    {
        $this->guardAgainstInvalidArguments();

        $mailable = app(MailableFactory::class)->getInstance(
            $this->argument('mailableClass'),
            $this->argument('recipient'),
            $this->getValues()
        );

        Mail::send($mailable);

        $this->comment('Mail sent!');
    }

    public function guardAgainstInvalidArguments()
    {
        $validator = Validator::make(
            ['email' => $this->argument('recipient')],
            ['email' => 'email']);

        if (!$validator->passes()) {
            throw new Exception("`{$this->argument('recipient')}` is not a valid e-mail address");
        }
    }

    protected function getValues(): array
    {
        if (! $this->option('values')) {
            return [];
        }

        $values = explode(',', $this->option('values'));

        return collect($values)
            ->mapWithKeys(function (string $value) {

                $values = explode(':', $value);

                if (count($values) != 2) {
                    throw new InvalidArgumentException("The given value for the option 'values' `{$this->option('values')}` is not valid.");
                }

                return [$values[0] => $values[1]];
            })
            ->toArray();
    }
}
