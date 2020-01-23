<?php

namespace Bakhritdinov\SMSManager\Contracts;

/**
 * Interface SmsMessageInterface
 * @package Bakhritdinov\SMSManager\Contracts
 */
interface SmsMessageInterface
{
    /**
     * @param string $message
     * @return SmsManagerInterface
     */
    public function withMessage(string $message): SmsManagerInterface;
}
