<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Http\Client;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TransactPro\Gateway\Exceptions\RequestException;
use TransactPro\Gateway\Interfaces\HttpTransportInterface;

class ClientTest extends TestCase
{
    public function testClientSuccess(): void
    {
        /** @var HttpTransportInterface|MockObject $stubTransport */
        $stubTransport = $this->createMock(HttpTransportInterface::class);

        $stubTransport->method('execute')->willReturn(true);
        $stubTransport->method('getStatus')->willReturn(404);
        $stubTransport->method('getHeaders')->willReturn(['X-Custom' => 'foo']);
        $stubTransport->method('getBody')->willReturn('test body');

        $client = new Client("/foo", $stubTransport);

        $resp = $client->request('testuser', 'testsecret', "/", "", "");

        $this->assertEquals("test body", $resp->getBody());
        $this->assertEquals('foo', $resp->getHeader('x-custom'));
        $this->assertEquals(404, $resp->getStatusCode());
    }

    public function testClientRequestException(): void
    {
        $this->expectException(RequestException::class);
        $this->expectExceptionMessage('custom error');

        /** @var HttpTransportInterface|MockObject $stubTransport */
        $stubTransport = $this->createMock(HttpTransportInterface::class);

        $stubTransport->method('execute')->willReturn(false);
        $stubTransport->method('error')->willReturn('custom error');

        $client = new Client("/foo", $stubTransport);

        $client->request('testuser', 'testsecret', "/", "", "");
    }
}
