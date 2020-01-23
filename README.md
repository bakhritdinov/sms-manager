# SMS Manager with opportunity automatic switching gateway

The package provides opportunity to implement your own SMS gateways however you want.

## Installation

```bash
composer require bakhritdinov/sms-manager
```

### Laravel
Register "Bakhritdinov\SMSManager\Support\LaravelServiceProvider" to the config/app.php configuration file:

```php
'providers' => [
    // Other service providers...

    Bakhritdinov\SMSManager\Support\LaravelServiceProvider::class,
],
```

Add the SMSManager facade to the aliases array of the configuration file:
```php
'SMSManager' => Bakhritdinov\SMSManager\Support\Facades\SMSManager::class,
```

Generate config/sms_manager.php

```php
php artisan vendor:publish
```

### Lumen
or bootstrap/app.php

```php
$app->register(Bakhritdinov\SMSManager\Support\LumenServiceProvider::class);
```

## Requirements
>PHP 7.1.3 higher

>Laravel or Lumen 5.7 higher

> Composer

## Features
- [x] Automatic switching SMS gateway by priority
- [x] Opportunity to control SMS gateways priority
- [x] Sending SMS notifications immediately
- [x] Sending SMS notifications via a queue in the background
- [x] Implement own SMS gateways without limits
- [x] Retry protection

## What is missing?
- [ ] Opportunity mass sending
- [ ] Controllers for SMS Gateway priority management

Over time, I will fix all the flaws, if you find any one, please, report me.

## Using
```php
SmsManager::getBuilder()
        ->toNumber(998974614334)
        ->withMessage('Hello! From default gateway')
        ->sendImmediately();
```

The first case sends SMS notification to the specified number using the SMS gateway with the highest priority.

The sendImmediately method sends messages without a queue, waiting for a response from the SMS center.

```php
SmsManager::getBuilder()
        ->toNumber(998974614334)
        ->withMessage('Hello! From first gateway')
        ->withGateway('first_gateway')
        ->sendImmediately();
```

The second case sends an SMS notification to the specified number, while defining the desired SMS gateway, but waiting for a response from the SMS center.

```php
SmsManager::getBuilder()
        ->toNumber(998974614334)
        ->withMessage('Hello! From queue')
        ->addToQueue();
```
The third case creates a queue for sending a message to the specified number, while also using the SMS gateway with the highest priority.

It is very useful. For example, when registering, the client does not have to wait for a response from the SMS center.

## License
[MIT](https://github.com/bakhritdinov/sms-manager/blob/master/LICENSE)
