<?php

namespace Bakhritdinov\SMSManager\Tests\Gateways;

use Bakhritdinov\SMSManager\Contracts\SmsGatewayInterface;

/**
 * Class SecondGateway
 * @package Bakhritdinov\SMSManager\Tests\Gateways
 */
class SecondGateway implements SmsGatewayInterface
{

    /**
     * @param string $message
     * @param string $phone
     * @return mixed
     */
    public function send(string $message, string $phone): bool
    {
        print 'second ' . $message . ' -> ' . $phone;

        return true;
    }
}