<?php

/*
|--------------------------------------------------------------------------
| SMS Manager
|--------------------------------------------------------------------------
|
| You can store these settings in the database.
|
*/
return [
    /*
    |--------------------------------------------------------------------------
    | Gateways table name
    |--------------------------------------------------------------------------
    |
    | Perhaps you 'sms_gateways' table name is busy, you can set a new table name here.
    | Migration and the model takes its name from here.
    |
    */
    'table_name' => 'sms_gateways',

    /*
    |--------------------------------------------------------------------------
    | Retry time in minutes
    |--------------------------------------------------------------------------
    |
    | It is advisable to display this setting in the frontend,
    | so that has the opportunity to block retry send
    |
    */
    'retry_time' => 1,

    /*
    |--------------------------------------------------------------------------
    | Priority cache time in minutes
    |--------------------------------------------------------------------------
    |
    | Priorities are stored in the cache,
    | it is recommended to set the value to more than 30
    |
    */
    'priority_cache_time' => 30,

    /*
    |--------------------------------------------------------------------------
    | Set cache prefix
    |--------------------------------------------------------------------------
    |
    | If the sms_ prefix is already in your cache, you can change it here
    |
    */
    'cache_prefix' => 'sms_',

    /*
    |--------------------------------------------------------------------------
    | Set cache driver
    |--------------------------------------------------------------------------
    |
    | Leave blank if you want SMSManager to use cache driver by default.
    |
    */
    'cache_driver' => '',

    /*
    |--------------------------------------------------------------------------
    | SMS Gateways class map
    |--------------------------------------------------------------------------
    |
    | The key - is class_id in sms_gateways table
    | Value - is your SMS gateway implementation
    |
    | Example:
    |   'gateway_name' => \Namespace\GatewayClass::class
    |
    | GatewayClass::class must implement the SmsGatewayInterface interface
    |
    */
    'gateways' => [

    ],
];