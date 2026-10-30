<?php

declare(strict_types=1);

namespace Phptg\TransportPsr\Tests;

use RuntimeException;

final readonly class TestHelper
{
    /**
     * @return resource
     */
    public static function createResourceFromString(string $value): mixed
    {
        $resource = fopen('php://temp', 'r+b');
        if ($resource === false) {
            throw new RuntimeException('Failed to open "php://temp".');
        }
        fwrite($resource, $value);
        rewind($resource);
        return $resource;
    }
}
