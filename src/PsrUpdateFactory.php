<?php

declare(strict_types=1);

namespace Phptg\TransportPsr;

use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\Type\Update\Update;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Factory for creating {@see Update} objects from PSR-7 server requests.
 */
final readonly class PsrUpdateFactory
{
    /**
     * Create a new {@see Update} object from PSR-7 server request.
     *
     * @throws TelegramParseResultException
     */
    public static function create(ServerRequestInterface $request, ?LoggerInterface $logger = null): Update
    {
        return Update::fromJson((string) $request->getBody(), $logger);
    }
}
