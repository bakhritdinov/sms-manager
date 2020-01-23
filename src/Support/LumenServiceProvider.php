<?php

namespace Bakhritdinov\SMSManager\Support;

/**
 * Class LumenServiceProvider
 * @package Bakhritdinov\SMSManager\Support
 */
class LumenServiceProvider extends ServiceProvider
{
    /**
     * Register resources
     */
    protected function registerResources()
    {
        $this->app->configure('sms_manager');
    }
}