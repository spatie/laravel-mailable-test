<?php

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
