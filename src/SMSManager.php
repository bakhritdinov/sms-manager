<?php

namespace Bakhritdinov\SMSManager;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Bakhritdinov\SMSManager\Jobs\SendSMS;
use Bakhritdinov\SMSManager\Models\SMSGateway;
use Bakhritdinov\SMSManager\Contracts\{
    SmsManagerInterface,
    SmsMessageInterface,
    SmsPhoneInterface
};
use Bakhritdinov\SMSManager\Exceptions\{
    SmsGatewayIsNotImplementedException,
    SmsRetryTimeException
};

/**
 * Class SmsManager
 * @package Bakhritdinov\SMSManager
 */
class SmsManager implements SmsPhoneInterface, SmsMessageInterface, SmsManagerInterface
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
     * @var null
     */
    protected $classId = null;

    /**
     * @var bool
     */
    private $_switchable = false;

    /**
     * SmsGateway constructor.
     */
    private function __construct()
    {
        if (config()->has('sms_manager.cache_driver')) {
            Cache::store(config('sms_manager.cache_driver'));
        }
    }

    private function __clone()
    {
    }

    /**
     * @return SmsPhoneInterface
     */
    public static function getBuilder(): SmsPhoneInterface
    {
        return new SmsManager();
    }

    /**
     * @param int $phone
     * @return $this
     */
    public function toNumber(int $phone): SmsMessageInterface
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @param string $message
     * @return SmsManagerInterface
     */
    public function withMessage(string $message): SmsManagerInterface
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return $this
     */
    public function enableSwitching(): SmsManagerInterface
    {
        $this->classId = null;
        $this->_switchable = true;
        return $this;
    }

    /**
     * @param string $gatewayClassId
     * @return SmsManagerInterface
     */
    public function withGateway(string $gatewayClassId): SmsManagerInterface
    {
        $this->_switchable = false;
        $this->classId = $gatewayClassId;
        return $this;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function addToQueue(): void
    {
        $this->checkPhoneAndMessage();
        $this->checkRetryTime();

        $gateway = $this->getGateway();

        $this->setRetry();

        dispatch(new SendSMS($this->phone, $this->message, $gateway->class_id));

        if ($this->_switchable) {
            $this->setGatewayPriority($gateway->priority);
        }
    }

    /**
     * @return bool
     * @throws SmsGatewayIsNotImplementedException
     * @throws \Exception
     */
    public function sendImmediately(): bool
    {
        $this->checkPhoneAndMessage();
        $this->checkRetryTime();

        return app()
            ->makeWith('SMSGateway', ['classId' => $this->getGateway()->class_id])
            ->send($this->message, $this->phone);
    }

    /**
     * @return mixed
     * @throws SmsGatewayIsNotImplementedException
     */
    protected function getGateway()
    {
        if ($this->classId) {
            try {
                return SMSGateway::where('active', true)
                    ->where('class_id', $this->classId)
                    ->firstOrFail();
            } catch (\Exception $e) {
                throw new SmsGatewayIsNotImplementedException();
            }
        }

        $gateways = SMSGateway::where('active', true);

        if ($this->_switchable) {
            $gateways->orderByRaw("priority <= ?", $this->getGatewayPriority());
        }

        try {
            return $gateways->firstOrFail();

        } catch (\Exception $e) {
            throw new SmsGatewayIsNotImplementedException();
        }
    }

    /**
     * @return void
     */
    protected function setRetry(): void
    {
        Cache::add(
            $this->getCacheKey() . '_retry',
            Carbon::now(),
            (config('sms_manager.retry_time') * 60)
        );
    }

    /**
     * @return int|null
     */
    protected function getRetry()
    {
        return Cache::get($this->getCacheKey() . '_retry');
    }

    /**
     * @param int $priority
     * @return void
     */
    protected function setGatewayPriority(int $priority): void
    {
        Cache::put(
            $this->getCacheKey() . '_priority', $priority,
            config('sms_manager.priority_cache_time') * 60
        );
    }

    /**
     * @return int|null
     */
    protected function getGatewayPriority()
    {
        return (int)Cache::get($this->getCacheKey() . '_priority');
    }

    /**
     * @return string
     */
    protected function getCacheKey(): string
    {
        $prefix = config('sms_manager.cache_prefix') ?: 'sms_';

        return $prefix . $this->phone;
    }

    /**
     * @return void
     * @throws \Exception
     */
    protected function checkPhoneAndMessage(): void
    {
        if (!$this->phone || !$this->message) {
            throw new \Exception(trans('sms_manager::exceptions.phone_or_message_missing'));
        }
    }

    /**
     * @return void
     * @throws SmsRetryTimeException
     */
    protected function checkRetryTime(): void
    {
        if ($this->getRetry()) {
            throw new SmsRetryTimeException();
        }
    }
}