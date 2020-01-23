<?php

namespace Bakhritdinov\SMSManager\Contracts;

/**
 * Interface SmsPhoneInterface
 * @package Bakhritdinov\SMSManager\Contracts
 */
interface SmsPhoneInterface
{
    /**
     * @param int $phoneNumber
     * @return SmsMessageInterface
     */
    public function toNumber(int $phoneNumber): SmsMessageInterface;
}
