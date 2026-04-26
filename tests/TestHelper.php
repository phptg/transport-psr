<?php

declare(strict_types=1);

namespace Phptg\TransportPsr\Tests;

final readonly class TestHelper
{
    /**
     * @return resource
     */
    public static function createResourceFromString(string $value): mixed
    {
        $resource = fopen('php://temp', 'r+b');
        fwrite($resource, $value);
        rewind($resource);
        return $resource;
    }
}
