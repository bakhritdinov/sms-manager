<?php

namespace Bakhritdinov\SMSManager\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Bakhritdinov\SMSManager\Contracts\SmsPhoneInterface;

/**
 * Class SMSManager
 * @package Bakhritdinov\SMSManager\Support\Facades
 */
class SMSManager extends Facade
{
    /**
     * @return SmsPhoneInterface|string
     */
    protected static function getFacadeAccessor()
    {
        return \Bakhritdinov\SMSManager\SmsManager::getBuilder();
    }
}