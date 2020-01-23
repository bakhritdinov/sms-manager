<?php

namespace Bakhritdinov\SMSManager\Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Bakhritdinov\SMSManager\SmsManager;
use Bakhritdinov\SMSManager\Tests\TestCase;
use Bakhritdinov\SMSManager\Models\SMSGateway;
use Bakhritdinov\SMSManager\Contracts\SmsPhoneInterface;
use Bakhritdinov\SMSManager\Exceptions\SmsRetryTimeException;
use Bakhritdinov\SMSManager\Exceptions\SmsGatewayIsNotImplementedException;

/**
 * Class SMSGatewayTest
 * @package Bakhritdinov\SMSManager\Tests\Feature
 */
class SMSGatewayTest extends TestCase
{
    use  RefreshDatabase;

    /**
     * @var SmsPhoneInterface
     */
    protected $smsBuilder;

    /**
     * Initialization
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->smsBuilder = SmsManager::getBuilder();
        Cache::setDefaultDriver('array');

        $this->withFactories(__DIR__ . '/../../database/factories');

        factory(SMSGateway::class, 'first_gateway')->create();
        factory(SMSGateway::class, 'second_gateway')->create();

        // Dev gateways
        config(['sms_manager.gateways' => [
            'first_gateway' => \Bakhritdinov\SMSManager\Tests\Gateways\FirstGateway::class,
            'second_gateway' => \Bakhritdinov\SMSManager\Tests\Gateways\SecondGateway::class,
        ]]);
    }

    /**
     * Test if programmer does not specify phone throws Exception
     * @test
     */
    public function test_without_phone_throws_exception()
    {
        $this->expectException(\Exception::class);
        $this
            ->smsBuilder
            ->withMessage('Hello')->addToQueue();
    }


    /**
     * Test if programmer does not specify message throws Exception
     * @test
     */
    public function test_without_message_throws_exception()
    {
        $this->expectException(\Exception::class);
        $this->smsBuilder
            ->toNumber(998933492496)
            ->addToQueue();
    }

    /**
     * Test if SMS gateway is not implemented throws SmsGatewayIsNotImplementedException
     * @test
     */
    public function test_throws_not_implemented_exception()
    {
        $this->expectException(SmsGatewayIsNotImplementedException::class);

        $this->smsBuilder
            ->toNumber(998933492496)
            ->withMessage('Hello')
            ->withGateway('not_exist')
            ->addToQueue();
    }

    /**
     * Test sending sms immediately without adding to the queue
     * @test
     */
    public function test_default_gateway_send_message_immediately()
    {
        $response = $this->smsBuilder
            ->toNumber(998974614334)
            ->withMessage('Hello, world! From default gateway')
            ->sendImmediately();

        $this->assertTrue($response);
    }

    /**
     * Test sending sms with first_gateway sms gateway
     * @test
     */
    public function test_first_gateway_send_message()
    {
        $response = $this->smsBuilder
            ->toNumber(998974614334)
            ->withMessage('Hello, world! From first gateway')
            ->withGateway('first_gateway')
            ->sendImmediately();

        $this->assertTrue($response);
    }

    /**
     * Test sending sms with second_gateway sms gateway
     * @test
     */
    public function test_second_gateway_send_message()
    {
        $response = $this->smsBuilder
            ->toNumber(998974614334)
            ->withMessage('Hello, world! From second gateway')
            ->withGateway('second_gateway')
            ->sendImmediately();

        $this->assertTrue($response);
    }

    /**
     * Test sending sms by adding to the queue
     * @test
     */
    public function test_add_to_queue()
    {
        $this->smsBuilder
            ->toNumber(998974614334)
            ->withMessage('Hello, world! From queue')
            ->addToQueue();

        $this->assertTrue(true);
    }

    /**
     * Test if user tries to re send sms before specified time passes
     * @test
     */
    public function test_retry_time_exception()
    {
        $this->expectException(SmsRetryTimeException::class);

        $this->smsBuilder
            ->toNumber(998933492496)
            ->withMessage('Hello from retry test')
            ->addToQueue();

        $this->smsBuilder
            ->toNumber(998933492496)
            ->withMessage('Hello from retry test again')
            ->addToQueue();
    }

    /**
     * Test SMS gateway switching feature
     * @test
     */
    public function test_enabling_switchable_gateway()
    {
        $this->smsBuilder
            ->toNumber(998933492496)
            ->withMessage('Test message with switchable functionality #1')
            ->enableSwitching()
            ->addToQueue();

        sleep(config('sms_manager.retry_time') * 60 + 1);

        $this->smsBuilder
            ->toNumber(998933492496)
            ->withMessage('Test message with switchable functionality #2')
            ->enableSwitching()
            ->addToQueue();

        sleep(config('sms_manager.retry_time') * 60 + 1);

        $this->smsBuilder
            ->toNumber(998933492496)
            ->withMessage('Test message with switchable functionality #3')
            ->enableSwitching()
            ->addToQueue();

        sleep(config('sms_manager.retry_time') * 60 + 1);

        $this->smsBuilder
            ->toNumber(998933492496)
            ->withMessage('Test message with switchable functionality #4')
            ->enableSwitching()
            ->addToQueue();

        $this->assertTrue(true);
    }
}