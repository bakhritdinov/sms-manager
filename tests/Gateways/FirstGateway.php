<?php

namespace Bakhritdinov\SMSManager\Tests\Gateways;

use Bakhritdinov\SMSManager\Contracts\SmsGatewayInterface;

/**
 * Class FirstGateway
 * @package Bakhritdinov\SMSManager\Tests\Gateways
 */
class FirstGateway implements SmsGatewayInterface
{

    /**
     * @param string $message
     * @param string $phone
     * @return mixed
     */
    public function send(string $message, string $phone): bool
    {
        print 'first ' . $message . ' -> ' . $phone;

        return true;
    }
}