<?php

namespace Spatie\MailableTest\Test;

use Event;
use Artisan;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\UptimeMonitor\UptimeMonitorServiceProvider;

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
