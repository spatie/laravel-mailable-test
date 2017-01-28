<?php

namespace Spatie\MailableTest;

use Exception;
use ReflectionClass;
use ReflectionParameter;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Database\Eloquent\Model;

class MailableFactory
{
    /**  @var \Spatie\MailableTest\ArgumentValueProvider */
    protected $argumentValueProvider;

    public function __construct(ArgumentValueProvider $argumentValueProvider)
    {
        $this->argumentValueProvider = $argumentValueProvider;
    }

    public function getInstance(string $mailableClass): Mailable
    {
        if (! class_exists($mailableClass)) {
            throw new Exception("Mailable `{$mailableClass}` does not exist.");
        }

        $argumentValues = $this->getArguments($mailableClass);

        return new $mailableClass(...$argumentValues);
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
}
