<?php

namespace Spatie\MailableTest;

use Exception;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Spatie\MailableTest\Exceptions\CouldNotDetermineValue;

class FakerArgumentValueProvider implements ArgumentValueProvider
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
     * @param string|null $defaultValue
     *
     * @return mixed
     */
    public function getValue(string $mailableClass, string $argumentName, string $argumentType = '', $defaultValue = null)
    {
        if ($argumentType === 'int') {
            return $defaultValue ?? $this->faker->numberBetween(1, 100);
        }

        if ($argumentType === 'string') {
            return $defaultValue ?? $this->faker->sentence();
        }

        if ($argumentType === 'bool') {
            $defaultValue = ($defaultValue == 'false' ? false : $defaultValue);

            return $defaultValue ?? $this->faker->boolean(50);
        }

        try {
            $argumentValue = app($argumentType);
        } catch (Exception $exception) {
            throw CouldNotDetermineValue::create($argumentType, $argumentName, $exception);
        }

        if ($argumentValue instanceof Model) {
            return $this->getModelInstance($mailableClass, $argumentName, $argumentValue, $id = $defaultValue);
        }

        return $argumentValue;
    }

    /**
     * @param string $mailableClass
     * @param string $argumentName
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string|int|null $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Spatie\MailableTest\Exceptions\CouldNotDetermineValue
     */
    protected function getModelInstance(string $mailableClass, string $argumentName, Model $model, $id): Model
    {
        $modelInstance = $id ? $model->find($id) : $model->first();

        if (! $modelInstance) {
            throw CouldNotDetermineValue::noModelInstanceFound($model);
        }

        return $modelInstance;
    }
}
