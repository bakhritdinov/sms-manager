<?php

namespace Bakhritdinov\SMSManager\Exceptions;

/**
 * Class SmsGatewayIsNotImplementedException
 * @package Bakhritdinov\SMSManager\Exceptions
 */
class SmsGatewayIsNotImplementedException extends \Exception
{
    /**
     * @var int
     */
    protected $code = 1002;

    /**
     * SmsGatewayIsNotImplementedException constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->message = $message ?: trans('sms_manager::exceptions.not_implemented');
    }
}
