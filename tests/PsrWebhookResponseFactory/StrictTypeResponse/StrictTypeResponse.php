<?php

declare(strict_types=1);

namespace Phptg\TransportPsr\Tests\PsrWebhookResponseFactory\StrictTypeResponse;

use HttpSoft\Message\ResponseTrait;
use LogicException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

use function is_string;

final class StrictTypeResponse implements ResponseInterface
{
    use ResponseTrait {
        normalizeHeaderValue as private traitNormalizeHeaderValue;
    }

    /**
     * @param array<string, string|string[]> $headers
     * @param StreamInterface|string|resource|null $body
     */
    public function __construct(
        int $statusCode = 200,
        string $reasonPhrase = '',
        array $headers = [],
        mixed $body = null,
        string $protocol = '1.1',
    ) {
        $this->init($statusCode, $reasonPhrase, $headers, $body, $protocol);
    }

    /**
     * @return array<mixed>
     */
    private function normalizeHeaderValue(mixed $value): array
    {
        $this->checkValue($value);
        return $this->traitNormalizeHeaderValue($value);
    }

    private function checkValue(mixed $value): void
    {
        if (is_string($value)) {
            return;
        }

        throw new LogicException(
            'Invalid header value: expected string, got ' . get_debug_type($value),
        );
    }
}
