<?php

namespace Spatie\MailableTest\Test;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /** @var \Spatie\UptimeMonitor\Test\Server */
    protected $server;

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        //$app['config']->set('database.default', 'sqlite');
    }
}
