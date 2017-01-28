<?php

namespace Spatie\MailableTest;

use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Spatie\MailableTest\Exceptions\CouldNotDetermineValue;

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
        $modelInstance = $model->first();

        if (! $modelInstance) {
            throw CouldNotDetermineValue::noModelInstanceFound($model);
        }

        return $modelInstance;
    }
}
