# An artisan command to easily test a mailable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-mailable-test.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-mailable-test)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/laravel-mailable-test/master.svg?style=flat-square)](https://travis-ci.org/spatie/laravel-mailable-test)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/c2dc5407-d2e5-4039-8798-ac3e1dba0c76.svg?style=flat-square)](https://insight.sensiolabs.com/projects/c2dc5407-d2e5-4039-8798-ac3e1dba0c76)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/laravel-mailable-test.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/laravel-mailable-test)
[![StyleCI](https://styleci.io/repos/80032119/shield?branch=master)](https://styleci.io/repos/80032119)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-mailable-test.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-mailable-test)

This package provides an artisan command that can send a mailable to an mail-address. It can be used like this:

```php
mail:send-test "App\Mail\MyMailable" recipent@mail.com
```

The given mailable will be sent to the given recipient. Any parameters the `__construct` method of the mailable class expect will be generated.

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

The best postcards will get published on the open source page on our website.

## Installation

You can install the package via composer:

``` bash
composer require spatie/laravel-mailable-test
```

Next, you must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    Spatie\MailableTest\MailableTestServiceProvider::class,
];
```

You can publish the config-file with:
```bash
php artisan vendor:publish --provider="Spatie\MailableTest\MailableTestServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
    
    /**
     * This class will be used to generate argument values for the constructor
     * of a mailable. This can be any class as long as it 
     * extends \Spatie\MailableTest\ArgumentValueProvider::class
     */
    'argument_value_provider_class' => \Spatie\MailableTest\ArgumentValueProvider::class,
];
```

## Usage


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

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
