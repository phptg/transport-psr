<?php

declare(strict_types=1);

namespace Phptg\TransportPsr\Tests;

use HttpSoft\Message\ServerRequest;
use HttpSoft\Message\StreamFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\Type\Update\Update;
use Phptg\TransportPsr\PsrUpdateFactory;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertSame;

final class PsrUpdateFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $request = new ServerRequest(
            body: (new StreamFactory())->createStream('{"update_id":33990940}')
        );

        $update = PsrUpdateFactory::create($request);
        assertSame(33990940, $update->updateId);
        assertSame('{"update_id":33990940}', $update->getRaw());
        assertSame(['update_id' => 33990940], $update->getRaw(true));

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Failed to decode JSON.');
        Update::fromJson('asdf{');
    }

    public function testBrokenJson(): void
    {
        $request = new ServerRequest(
            body: (new StreamFactory())->createStream('asdf{')
        );

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Failed to decode JSON.');
        PsrUpdateFactory::create($request);
    }
}
