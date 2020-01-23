<?php

namespace Bakhritdinov\SMSManager\Contracts;

/**
 * Interface SmsGatewayInterface
 * @package Bakhritdinov\SMSManager\Contracts
 */
interface SmsGatewayInterface
{
    /**
     * @param string $message
     * @param string $phone
     * @return mixed
     */
    public function send(string $message, string $phone): bool;
}
