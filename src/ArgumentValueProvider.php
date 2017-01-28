<?php

namespace Spatie\MailableTest;

use Faker\Generator;

class ArgumentValueProvider
{
    /** @var \Faker\Generator  */
    protected $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    public function getValue(string $argumentName, string $argumentType = '')
    {
        if ($argumentType === 'int') {
            return $this->faker->numberBetween(1, 100);
        }

        if ($argumentType === 'string') {
            return $this->faker->sentence();
        }

        if ($argumentType === 'bool') {
            return $this->faker->boolean(50);
        }


        $argumentValue = app($argumentType);

        if ($argumentValue instanceof Model) {
            $argumentValue = $this->getModelInstance($argumentValue);
        }

        return $argumentValue;
    }

    protected function getModelInstance(Model $model)
    {
        $model = $model->first();

        if (! $model) {
            $modelClass = get_class($model);
            throw new Exception("Could not find a model of class `{$modelClass}`.");
        }

        return $model;
    }
}
