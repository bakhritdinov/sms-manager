<?php

namespace Bakhritdinov\SMSManager\Jobs;

use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Log;

/**
 * Class SendSMS
 * @package Bakhritdinov\SMSManager\Jobs
 */
class SendSMS extends Job
{
    /**
     * @var int
     */
    protected $phone;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $gatewayClassId;

    /**
     * SendSms constructor.
     * @param int $phone
     * @param string $message
     * @param string $gatewayClassId
     */
    public function __construct(int $phone, string $message, string $gatewayClassId)
    {
        $this->phone = $phone;
        $this->message = $message;
        $this->gatewayClassId = $gatewayClassId;
    }

    /**
     * Send SMS
     * @return void
     */
    public function handle(): void
    {
        app()->makeWith('SMSGateway', ['classId' => $this->gatewayClassId])
            ->send($this->message, $this->phone);
    }

    /**
     * Get the job identifier.
     *
     * @return string
     */
    public function getJobId()
    {
    }

    /**
     * Get the raw body of the job.
     *
     * @return string
     */
    public function getRawBody()
    {
    }
}
