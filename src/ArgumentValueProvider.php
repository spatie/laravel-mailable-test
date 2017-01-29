<?php

namespace Spatie\MailableTest;

use Exception;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Spatie\MailableTest\Exceptions\CouldNotDetermineValue;

class ArgumentValueProvider
{
    /** @var \Faker\Generator */
    protected $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    /**
     * @param string $mailableClass
     * @param string $argumentName
     * @param string $argumentType
     *
     * @return mixed
     * @throws \Spatie\MailableTest\Exceptions\CouldNotDetermineValue
     */
    public function getValue(string $mailableClass, string $argumentName, string $argumentType = '')
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

        try {
            $argumentValue = app($argumentType);
        } catch (Exception $exception) {
            throw CouldNotDetermineValue::create($argumentType, $argumentName, $exception);
        }

        if ($argumentValue instanceof Model) {
            return $this->getModelInstance($argumentValue);
        }

        return $argumentValue;
    }

    protected function getModelInstance(Model $model): Model
    {
        $modelInstance = $model->first();

        if (! $modelInstance) {
            throw CouldNotDetermineValue::noModelInstanceFound($model);
        }

        return $modelInstance;
    }
}
