<?php

namespace Spatie\MailableTest\Test;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{


    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');

        $app['config']->set('mail.driver', 'log');

        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'prefix' => '',
            'database' => ':memory:',
        ]);

        $this->setUpDatabase();
    }

    protected function setUpDatabase()
    {
        include_once __DIR__.'/../database/migrations/create_monitors_table.php.stub';

        (new \CreateMonitorsTable())->up();
    }
}
