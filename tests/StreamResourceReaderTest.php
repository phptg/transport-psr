<?php

declare(strict_types=1);

namespace Phptg\TransportPsr\Tests;

use Phptg\TransportPsr\StreamResourceReader;
use PHPUnit\Framework\TestCase;
use stdClass;
use Yiisoft\Test\Support\HttpMessage\StringStream;
use PHPUnit\Framework\Attributes\DataProvider;

use function PHPUnit\Framework\assertSame;

final class StreamResourceReaderTest extends TestCase
{
    public function testRead(): void
    {
        $stream = new StringStream('hello');
        $reader = new StreamResourceReader();

        assertSame('hello', $reader->read($stream));
    }

    public function testReadRewindsSeekableStream(): void
    {
        $stream = new StringStream('hello', position: 5);
        $reader = new StreamResourceReader();

        assertSame('hello', $reader->read($stream));
    }

    public function testReadNonSeekableStream(): void
    {
        $stream = new StringStream('content', seekable: false);
        $reader = new StreamResourceReader();

        assertSame('content', $reader->read($stream));
    }

    public function testGetUri(): void
    {
        $stream = new StringStream('hello', metadata: ['uri' => 'php://memory']);
        $reader = new StreamResourceReader();

        assertSame('php://memory', $reader->getUri($stream));
    }

    public static function dataSupports(): iterable
    {
        yield 'StreamInterface' => [new StringStream('hello'), true];
        yield 'string' => ['string', false];
        yield 'int' => [123, false];
        yield 'null' => [null, false];
        yield 'object' => [new stdClass(), false];
    }

    #[DataProvider('dataSupports')]
    public function testSupports(mixed $resource, bool $expected): void
    {
        $reader = new StreamResourceReader();

        assertSame($expected, $reader->supports($resource));
    }
}
