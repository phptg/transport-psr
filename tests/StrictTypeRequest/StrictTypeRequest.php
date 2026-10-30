<?php

declare(strict_types=1);

namespace Phptg\TransportPsr\Tests\StrictTypeRequest;

use HttpSoft\Message\RequestTrait;
use LogicException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

use function is_array;
use function is_string;

final class StrictTypeRequest implements RequestInterface
{
    use RequestTrait {
        normalizeHeaderValue as private traitNormalizeHeaderValue;
    }

    /**
     * @param array<string, string|string[]> $headers
     * @param StreamInterface|string|resource|null $body
     */
    public function __construct(
        string $method = 'GET',
        UriInterface|string $uri = '',
        array $headers = [],
        mixed $body = null,
        string $protocol = '1.1',
    ) {
        $this->init($method, $uri, $headers, $body, $protocol);
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
        if (is_array($value)) {
            foreach ($value as $item) {
                if (!is_string($item)) {
                    throw new LogicException('Invalid value.');
                }
            }
            return;
        }
        if (is_string($value)) {
            return;
        }
        throw new LogicException('Invalid value.');
    }
}
