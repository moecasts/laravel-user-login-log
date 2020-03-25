<?php

namespace Moecasts\Laravel\UserLoginLog\Test;

use Moecasts\Laravel\UserLoginLog\UserLoginLogServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{

    protected function getPackageProviders($app): array
    {
        return [UserLoginLogServiceProvider::class];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom([
            '--database' => 'testbench',
            '--path' => __DIR__ . '/../database/migrations'
        ]);

        $this->loadMigrationsFrom([
            '--database' => 'testbench',
            '--path' => __DIR__ . '/database/migrations'
        ]);
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
