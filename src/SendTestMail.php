<?php

namespace Spatie\MailableTest;

use Illuminate\Console\Command;
use InvalidArgumentException;
use Mail;
use Validator;

class SendTestMail extends Command
{
    protected $signature = 'mail:send-test {mailableClass} {recipient} {--values=}';

    protected $description = 'Send a test email';

    public function handle()
    {
        $this->guardAgainstInvalidArguments();

        $mailableClass = $this->getMailableClass();

        $mailable = app(MailableFactory::class)->getInstance(
            $mailableClass,
            $this->argument('recipient'),
            $this->getValues()
        );

        Mail::send($mailable);

        $this->comment("Mailable `{$mailableClass}` sent to {$this->argument('recipient')}!");
    }

    protected function guardAgainstInvalidArguments()
    {
        $validator = Validator::make(
            ['email' => $this->argument('recipient')],
            ['email' => 'email']
        );

        if (! $validator->passes()) {
            throw new InvalidArgumentException("`{$this->argument('recipient')}` is not a valid e-mail address");
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

    protected function getMailableClass()
    {
        $mailableClass = $this->argument('mailableClass');

        if (! class_exists($mailableClass)) {
            $mailableClass = sprintf('%s\\%s', config('mailable-test.base_namespace'), $mailableClass);

            if (! class_exists($mailableClass)) {
                throw new InvalidArgumentException("Mailable `{$mailableClass}` does not exist.");
            }
        }

        return $mailableClass;
    }
}
