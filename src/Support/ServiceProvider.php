<?php

namespace Bakhritdinov\SMSManager\Support;

use \Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Bakhritdinov\SMSManager\SmsGatewayStrategyContext;

/**
 * Class ServiceProvider
 * @package Bakhritdinov\SMSManager\Support
 */
abstract class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/sms_manager.php', 'sms_manager'
        );

        $this->app->singleton('SMSGateway', SmsGatewayStrategyContext::class);
    }

    /**
     * Boot services for SMSManager
     */
    public function boot()
    {
        $this->registerResources();

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'sms_manager');
    }

    /**
     * Register resources
     */
    abstract protected function registerResources();
}