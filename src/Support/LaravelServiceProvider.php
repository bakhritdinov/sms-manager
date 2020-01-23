<?php

namespace Bakhritdinov\SMSManager\Support;

/**
 * Class LaravelServiceProvider
 * @package Bakhritdinov\SMSManager\Support
 */
class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Register resources
     */
    protected function registerResources()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/sms_manager.php' => config_path('sms_manager.php')
            ], 'config');
        }
    }
}