<?php

declare(strict_types=1);

namespace Phptg\TransportPsr\Tests\StrictTypeRequest;

use HttpSoft\Message\Response;
use HttpSoft\Message\StreamFactory;
use Phptg\BotApi\Type\InputFile;
use Phptg\TransportPsr\PsrTransport;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

use function PHPUnit\Framework\assertSame;

final class StrictTypeRequestTest extends TestCase
{
    public function testWithHeader(): void
    {
        $streamFactory = new StreamFactory();

        $httpResponse = new Response(201, body: $streamFactory->createStream('hello'));

        $client = $this->createMock(ClientInterface::class);
        $client->method('sendRequest')->willReturn($httpResponse);

        $transport = new PsrTransport(
            $client,
            new StrictTypeRequestFactory(),
            $streamFactory,
        );

        $file = new InputFile(
            $streamFactory->createStream('file content'),
        );
        $response = $transport->postWithFiles(
            'https://api.example.com/test',
            ['key1' => 'value1'],
            ['file1' => $file],
        );

        assertSame(201, $response->statusCode);
        assertSame('hello', $response->body);
    }
}
