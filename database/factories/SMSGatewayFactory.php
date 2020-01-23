<?php

$factory->defineAs(\Bakhritdinov\SMSManager\Models\SMSGateway::class, 'first_gateway', function ($faker) use ($factory) {
    return [
        'name' => 'FirstGateway',
        'description' => 'sms gateway service',
        'class_id' => 'first_gateway',
        'priority' => 1
    ];
});

$factory->defineAs(\Bakhritdinov\SMSManager\Models\SMSGateway::class, 'second_gateway', function ($faker) use ($factory) {
    return [
        'name' => 'SecondGateway',
        'description' => 'sms gateway service',
        'class_id' => 'second_gateway',
        'priority' => 2
    ];
});