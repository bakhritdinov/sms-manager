<?php

namespace Bakhritdinov\SMSManager\Contracts;

/**
 * Interface SmsManagerInterface
 * @package Bakhritdinov\SMSManager\Contracts
 */
interface SmsManagerInterface
{
    /**
     * @param string $gatewayClassId
     * @return SmsManagerInterface
     */
    public function withGateway(string $gatewayClassId): SmsManagerInterface;

    /**
     * @return SmsManagerInterface
     */
    public function enableSwitching(): SmsManagerInterface;

    /**
     * @return void
     */
    public function addToQueue(): void;

    /**
     * @return bool
     */
    public function sendImmediately(): bool;
}
