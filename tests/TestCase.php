<?php

namespace Bakhritdinov\SMSManager\Tests;

use Illuminate\Foundation\Application;
use Bakhritdinov\SMSManager\Support\LaravelServiceProvider;
use Bakhritdinov\SMSManager\Support\LumenServiceProvider;

/**
 * Class TestCase
 * @package Bakhritdinov\SMSManager\Tests
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaravelServiceProvider::class,
//            LumenServiceProvider::class,
        ];
    }

    /**
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testdb');
        $app['config']->set('database.connections.testdb', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}