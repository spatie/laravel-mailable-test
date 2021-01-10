# An artisan command to easily test a mailable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-mailable-test.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-mailable-test)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/spatie/laravel-mailable-test/run-tests?label=tests)
![Check & fix styling](https://github.com/spatie/laravel-mailable-test/workflows/Check%20&%20fix%20styling/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-mailable-test.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-mailable-test)

Do you have to fill out an entire form just to test a mail sent by your app? Or even worse, complete an entire checkout process to just view and debug an order confirmation mail? Stop. The. Madness.

This package provides an artisan command that can send a mailable to an email-address. It can be used like this:

```bash
php artisan mail:send-test "OrderConfirmation" recipient@mail.com
```

The given mailable will be sent to the given recipient. Any parameters handed to the `__construct` method of the mailable class will be automatically passed in.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-mailable-test.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-mailable-test)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

``` bash
composer require spatie/laravel-mailable-test
```

The package will automatically register itself.

Optionally you can publish the config-file with:

```bash
php artisan vendor:publish --provider="Spatie\MailableTest\MailableTestServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [

    /*
     * This class will be used to generate argument values for the constructor
     * of a mailable. This can be any class as long as it
     * extends \Spatie\MailableTest\ArgumentValueProvider::class
     */
    'argument_value_provider_class' => \Spatie\MailableTest\FakerArgumentValueProvider::class,

    /*
     * Base namespace Mailable classes
     */
    'base_namespace' => 'App\Mail',
];
```

## Usage

To send any mailable issue this artisan command:

```bash
php artisan mail:send-test "App\Mail\MyMailable" recipient@mail.com
```

This will send the given mailable to the given mail-address. The to-, cc- and bcc-address that may be set in the given mailable will be cleared. The mail will only be sent to the mail-address given in the artisan command.

The package will provide a value for any typehinted argument of the constructor of the mailable. If a argument is a `int`, `string` or `bool` the package will generated a value using [Faker](https://github.com/FakerPHP/Faker). Any argument that typehints an Eloquent model will receive the first record of that model. For all arguments that have a class typehint an argument will be generated using the container.

## Customizing the values passed to the mailable constructor

### Via the command

The easiest way to customize the values passed to the mailable constructor is to use the `values` option of the `mail:send-test` command.  Image the constructor for your mailable looks like this:

```php
public function __construct(string $title, Order $order) 
{
   ...
}
```

The `Order` class in this example is an eloquent model. If you don't want the package to generate fake values or use the first `Order`, you can pass a `values` option to the command. The option should get a string with comma separated pair. The first value of each pair (separated by ':') should be the name of the argument in the mailable constructor. The second value should be the value that should be passed to that argument. For arguments concerning Eloquent models, the passed value will be used as the id.

So in this example `My title` will be passed to `$title` and an `Order` with id 5 will be passed to `$order`.

```php
php artisan mail:send-test "App\Mail\OrderConfirmation" recipient@mail.com --values="title:My title,order:5"
```

### By overriding the `ArgumentValueProvider`

The class that is responsible for getting values that should be passed on to the mailable constructor is `Spatie\MailableTest\FakerArgumentValueProvider`. You can override this class by specifying your own class in the `argument_value_provider_class` in the `laravel-mailable-test` config file.

By default the package will pass the first record of an Eloquent model to each argument that typehints a model. If you want to use your factories instead, you can do this.
 
```php
namespace App;

use Spatie\MailableTest\FakerArgumentValueProvider;

class MyCustomArgumentValueProvider extends FakerArgumentValueProvider
{
       protected function getModelInstance(string $mailableClass, string $argumentName, Model $model, $id): Model
       {
          return factory(get_class($model));
       }
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
