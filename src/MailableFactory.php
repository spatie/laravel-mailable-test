<?php

namespace Spatie\MailableTest;

use Exception;
use ReflectionClass;
use ReflectionParameter;
use Illuminate\Mail\Mailable;

class MailableFactory
{
    /** @var \Spatie\MailableTest\ArgumentValueProvider */
    protected $argumentValueProvider;

    public function __construct(ArgumentValueProvider $argumentValueProvider)
    {
        $this->argumentValueProvider = $argumentValueProvider;
    }

    public function getInstance(string $mailableClass, string $toEmail): Mailable
    {
        if (! class_exists($mailableClass)) {
            throw new Exception("Mailable `{$mailableClass}` does not exist.");
        }

        $argumentValues = $this->getArguments($mailableClass);

        $mailableInstance = new $mailableClass(...$argumentValues);

        $mailableInstance = $this->setRecipient($mailableInstance, $toEmail);

        return $mailableInstance;
    }

    public function getArguments(string $mailableClass)
    {
        $parameters = (new ReflectionClass($mailableClass))
            ->getConstructor()
            ->getParameters();

        return collect($parameters)
            ->map(function (ReflectionParameter $reflectionParameter) {
                return $this->argumentValueProvider->getValue(
                    $reflectionParameter->getName(),
                    $reflectionParameter->getType()->getName()
                );
            });
    }

    protected function setRecipient(Mailable $mailableInstance, string $toEmail): Mailable
    {
        $mailableInstance->to($toEmail);
        $mailableInstance->cc([]);
        $mailableInstance->bcc([]);

        return $mailableInstance;
    }
}
