<?php

namespace Bakhritdinov\SMSManager;

use Bakhritdinov\SMSManager\Contracts\SmsGatewayInterface;
use Bakhritdinov\SMSManager\Exceptions\SmsGatewayIsNotImplementedException;

/**
 * Class SmsGatewayStrategyContext
 * @package Bakhritdinov\SMSManager
 */
class SmsGatewayStrategyContext
{
    /**
     * @var SmsGatewayInterface
     */
    private $_gateway;

    /**
     * SmsGatewayStrategyContext constructor.
     * @param string $classId
     * @throws SmsGatewayIsNotImplementedException
     */
    public function __construct(string $classId)
    {
        $this->_gateway = $this->getGatewayByClassId($classId);
    }

    /**
     * @param string $message
     * @param int $phone
     * @return mixed
     */
    public function send(string $message, int $phone)
    {
        return $this->_gateway->send($message, $phone);
    }

    /**
     * @param string $classId
     * @return $this
     * @throws SmsGatewayIsNotImplementedException
     */
    public function setGateway(string $classId)
    {
        $this->_gateway = $this->getGatewayByClassId($classId);
        return $this;
    }

    /**
     * @return SmsGatewayInterface
     */
    public function getGateway()
    {
        return $this->_gateway;
    }

    /**
     * @param $classId
     * @return mixed
     * @throws SmsGatewayIsNotImplementedException
     */
    protected function getGatewayByClassId($classId)
    {
        $classPath = collect(config('sms_manager.gateways'))
            ->get($classId);

        if (!$classPath) {
            throw new SmsGatewayIsNotImplementedException();
        }

        $class = app($classPath);

        if (!$class instanceof SmsGatewayInterface) {
            throw new SmsGatewayIsNotImplementedException();
        }

        return $class;
    }
}