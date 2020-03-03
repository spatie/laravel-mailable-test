<?php

namespace Spatie\MailableTest;

use Illuminate\Mail\Mailable;
use ReflectionClass;
use ReflectionParameter;

class MailableFactory
{
    /** @var \Spatie\MailableTest\FakerArgumentValueProvider */
    protected $argumentValueProvider;

    public function __construct(ArgumentValueProvider $argumentValueProvider)
    {
        $this->argumentValueProvider = $argumentValueProvider;
    }

    public function getInstance(string $mailableClass, string $toEmail, $defaultValues): Mailable
    {
        $argumentValues = $this->getArguments($mailableClass, $defaultValues);

        $mailable = new $mailableClass(...$argumentValues);

        $mailable = $this->setRecipient($mailable, $toEmail);

        return $mailable;
    }

    public function getArguments(string $mailableClass, array $defaultValues)
    {
        $parameters = (new ReflectionClass($mailableClass))
            ->getConstructor()
            ->getParameters();

        return collect($parameters)
            ->map(function (ReflectionParameter $reflectionParameter) use ($mailableClass, $defaultValues) {
                return $this->argumentValueProvider->getValue(
                    $mailableClass,
                    $reflectionParameter->getName(),
                    $reflectionParameter->getType()->getName(),
                    $defaultValues[$reflectionParameter->getName()] ?? null
                );
            });
    }

    protected function setRecipient(Mailable $mailable, string $email): Mailable
    {
        $mailable->to($email);
        $mailable->cc([]);
        $mailable->bcc([]);

        return $mailable;
    }
}
