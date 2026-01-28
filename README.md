<div align="center">
    <a href="https://github.com/phptg">
        <img src="logo.png" alt="PHPTG">
    </a>
    <h1 align="center">PSR Transport for Telegram Bot API</h1>
    <br>
</div>

[![Latest Stable Version](https://poser.pugx.org/phptg/transport-psr/v)](https://packagist.org/packages/phptg/transport-psr)
[![Total Downloads](https://poser.pugx.org/phptg/transport-psr/downloads)](https://packagist.org/packages/phptg/transport-psr)
[![Build status](https://github.com/phptg/transport-psr/actions/workflows/build.yml/badge.svg)](https://github.com/phptg/transport-psr/actions/workflows/build.yml)
[![Coverage Status](https://coveralls.io/repos/github/phptg/transport-psr/badge.svg)](https://coveralls.io/github/phptg/transport-psr)
[![Mutation score](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fphptg%2Ftransport-psr%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/phptg/transport-psr/master)
[![Static analysis](https://github.com/phptg/transport-psr/actions/workflows/psalm.yml/badge.svg?branch=master)](https://github.com/phptg/transport-psr/actions/workflows/psalm.yml?query=branch%3Amaster)

The package provides for [phptg/bot-api](https://github.com/phptg/bot-api):

- [PSR-18](https://www.php-fig.org/psr/psr-18/) and [PSR-17](https://www.php-fig.org/psr/psr-17/) compatible transport implementation;
- [PSR-7](https://www.php-fig.org/psr/psr-7/) webhook response factory.

It allows you to use any PSR-compliant HTTP client to make requests to the Telegram Bot API.

> [!IMPORTANT]
> This project is developed and maintained by [Sergei Predvoditelev](https://github.com/vjik).
> Community support helps keep the project actively developed and well maintained.
> You can support the project using the following services:
>
> - [Boosty](https://boosty.to/vjik)
> - [CloudTips](https://pay.cloudtips.ru/p/192ce69b)
>
> Thank you for your support ❤️

## Requirements

- PHP 8.2 - 8.5.

## Installation

The package can be installed with [Composer](https://getcomposer.org/download/):

```shell
composer require phptg/transport-psr
```

## General usage

First, install a PSR-18 HTTP client and PSR-17 HTTP factories. For example, you can use [php-http/curl-client](https://github.com/php-http/curl-client) 
and [httpsoft/http-message](https://github.com/httpsoft/http-message):

```shell
composer require php-http/curl-client httpsoft/http-message
```

### PSR transport

Create an instance of `PsrTransport` and pass it to `TelegramBotApi`:

```php
use Http\Client\Curl\Client;
use HttpSoft\Message\RequestFactory;
use HttpSoft\Message\ResponseFactory;
use HttpSoft\Message\StreamFactory;
use Phptg\BotApi\TelegramBotApi;
use Phptg\TransportPsr\PsrTransport;

$streamFactory = new StreamFactory();
$responseFactory = new ResponseFactory();
$requestFactory = new RequestFactory();
$client = new Client($responseFactory, $streamFactory);

$transport = new PsrTransport(
    $client,
    $requestFactory,
    $streamFactory,
);

$api = new TelegramBotApi(
    token: '110201543:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw',
    transport: $transport,
);

// Now you can use the API as usual
$api->sendMessage(
    chatId: 123456789,
    text: 'Hello from PSR transport!',
);
```

`PsrTransport` constructor parameters:

- `$client` — PSR-18 HTTP client;
- `$requestFactory` — PSR-17 HTTP request factory;
- `$streamFactory` — PSR-17 HTTP stream factory.

### PSR webhook response factory

The `PsrWebhookResponseFactory` creates PSR-7 compliant HTTP responses for webhook handlers:

```php
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Phptg\BotApi\Method\SendMessage;
use Phptg\BotApi\WebhookResponse\PsrWebhookResponseFactory;
use Phptg\BotApi\WebhookResponse\WebhookResponse;

/**
 * @var ResponseFactoryInterface $responseFactory
 * @var StreamFactoryInterface $streamFactory
 */

$factory = new PsrWebhookResponseFactory($responseFactory, $streamFactory);

// Create response from WebhookResponse object
$webhookResponse = new WebhookResponse(new SendMessage(chatId: 12345, text: 'Hello!'));
$response = $factory->create($webhookResponse);

// Or create response directly from method, if you are sure that InputFile is not used
$method = new SendMessage(chatId: 12345, text: 'Hello!');
$response = $factory->byMethod($method);
```

The factory automatically:

- encodes the data as JSON;
- sets the `Content-Type` header to `application/json; charset=utf-8`;
- sets the `Content-Length` header.

## Documentation

- [Internals](docs/internals.md)

If you have any questions or problems with this package, use [author telegram chat](https://t.me/predvoditelev_chat) for communication.

## License

The `phptg/transport-psr` is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE) for more information.
