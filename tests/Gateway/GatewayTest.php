<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway;

use PHPUnit\Framework\TestCase;
use TransactPro\Gateway\DataSets\Auth;
use TransactPro\Gateway\Exceptions\GatewayException;
use TransactPro\Gateway\Exceptions\ValidatorException;
use TransactPro\Gateway\Interfaces\HttpClientInterface;
use TransactPro\Gateway\Interfaces\ResponseInterface;
use TransactPro\Gateway\Operations\Info\History;
use TransactPro\Gateway\Operations\Info\Result;
use TransactPro\Gateway\Operations\Info\Status;
use TransactPro\Gateway\Operations\Transactions\Cancel;
use TransactPro\Gateway\Operations\Transactions\Credit;
use TransactPro\Gateway\Operations\Transactions\DmsCharge;
use TransactPro\Gateway\Operations\Transactions\DmsHold;
use TransactPro\Gateway\Operations\Transactions\InitRecurrentDms;
use TransactPro\Gateway\Operations\Transactions\InitRecurrentSms;
use TransactPro\Gateway\Operations\Transactions\MotoDms;
use TransactPro\Gateway\Operations\Transactions\MotoSms;
use TransactPro\Gateway\Operations\Transactions\P2P;
use TransactPro\Gateway\Operations\Transactions\RecurrentDms;
use TransactPro\Gateway\Operations\Transactions\RecurrentSms;
use TransactPro\Gateway\Operations\Transactions\Refund;
use TransactPro\Gateway\Operations\Transactions\Reversal;
use TransactPro\Gateway\Operations\Transactions\Sms;

class GatewayTest extends TestCase
{
    public function testGateway()
    {
        $gw = new Gateway();

        /** @var HttpClientInterface|\PHPUnit_Framework_MockObject_MockObject $httpClientStub */
        $httpClientStub = $this->createMock(HttpClientInterface::class);
        $httpClientStub->method('request')->willReturn(new class implements ResponseInterface {
            function getStatusCode(): int
            {
                return 200;
            }

            function setHeader(string $header, string $value): ResponseInterface
            {
                return $this;
            }

            function getHeaders(): array
            {
                return [];
            }

            function getHeader(string $header): string
            {
                return 'aaa';
            }

            function getBody(): string
            {
                return 'holy moly';
            }
        });

        $gw->setHttpClient($httpClientStub);

        $this->assertInstanceOf(Auth::class, $gw->auth());
        $this->assertInstanceOf(Sms::class, $gw->createSms());
        $this->assertInstanceOf(DmsHold::class, $gw->createDmsHold());
        $this->assertInstanceOf(DmsCharge::class, $gw->createDmsCharge());
        $this->assertInstanceOf(Cancel::class, $gw->createCancel());
        $this->assertInstanceOf(MotoSms::class, $gw->createMotoSms());
        $this->assertInstanceOf(MotoDms::class, $gw->createMotoDms());
        $this->assertInstanceOf(Credit::class, $gw->createCredit());
        $this->assertInstanceOf(P2P::class, $gw->createP2P());
        $this->assertInstanceOf(InitRecurrentSms::class, $gw->createInitRecurrentSms());
        $this->assertInstanceOf(InitRecurrentDms::class, $gw->createInitRecurrentDms());
        $this->assertInstanceOf(RecurrentSms::class, $gw->createRecurrentSms());
        $this->assertInstanceOf(RecurrentDms::class, $gw->createRecurrentDms());
        $this->assertInstanceOf(Refund::class, $gw->createRefund());
        $this->assertInstanceOf(Reversal::class, $gw->createReversal());

        $this->assertInstanceOf(Result::class, $gw->createResult());
        $this->assertInstanceOf(History::class, $gw->createHistory());
        $this->assertInstanceOf(Status::class, $gw->createStatus());

        $status = $gw->createStatus();
        $status->info()->setGatewayTransactionIDs(['example-key']);

        $req = $status->build();
        $res = $gw->process($req);
        $this->assertEquals('holy moly', $res->getBody());
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertEquals('aaa', $res->getHeader('demo'));
        $this->assertEquals("{\"data\":{\"command-data\":{\"gateway-transaction-ids\":[\"example-key\"]}}}", $req->getPreparedData());
    }

    public function testGatewayException()
    {
        $this->expectException(GatewayException::class);

        $gw = new Gateway();

        $sms = $gw->createSms();
        $req = $sms->build();

        $gw->process($req);
    }

    public function testGenerateRequest()
    {
        $gw = new Gateway();

        $status = $gw->createStatus();
        $status->info()->setGatewayTransactionIDs(['example-key']);

        $req = $gw->generateRequest($status);

        $this->assertEquals('POST', $req->getMethod());
        $this->assertEquals('/status', $req->getPath());
        $this->assertEquals("{\"data\":{\"command-data\":{\"gateway-transaction-ids\":[\"example-key\"]}}}", $req->getPreparedData());
    }

    public function testGenerateRequestThrowException()
    {
        $this->expectException(ValidatorException::class);

        $gw = new Gateway();

        $status = $gw->createSms();

        $gw->generateRequest($status);
    }
}
