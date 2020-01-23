<?php

namespace Bakhritdinov\SMSManager\Exceptions;

/**
 * Class SmsRetryTimeException
 * @package Bakhritdinov\SMSManager\Exceptions
 */
class SmsRetryTimeException extends \Exception
{
    /**
     * @var int
     */
    protected $code = 1000;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = trans('sms_manager::exceptions.retry_time');
    }
}
