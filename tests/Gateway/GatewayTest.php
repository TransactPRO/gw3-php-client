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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use TransactPro\Gateway\DataSets\Auth;
use TransactPro\Gateway\Exceptions\GatewayException;
use TransactPro\Gateway\Exceptions\ValidatorException;
use TransactPro\Gateway\Interfaces\HttpClientInterface;
use TransactPro\Gateway\Interfaces\ResponseInterface;
use TransactPro\Gateway\Operations\Info\History;
use TransactPro\Gateway\Operations\Info\Result;
use TransactPro\Gateway\Operations\Info\Status;
use TransactPro\Gateway\Operations\Token\CreateToken;
use TransactPro\Gateway\Operations\Transactions\B2P;
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
use TransactPro\Gateway\Operations\Verify\Enrolled3D;
use TransactPro\Gateway\Operations\Verify\VerifyCard;
use TransactPro\Gateway\Responses\CsvResponse;

class GatewayTest extends TestCase
{
    public function testGateway(): void
    {
        $gw = new Gateway();
        $csvResponseMock = $this->createMock(CsvResponse::class);

        /** @var HttpClientInterface|MockObject $httpClientStub */
        $httpClientStub = $this->createMock(HttpClientInterface::class);
        $httpClientStub->method('request')->willReturn(new class($csvResponseMock) implements ResponseInterface {
            private $csvResponseMock;

            public function __construct($csvResponseMock)
            {
                $this->csvResponseMock = $csvResponseMock;
            }

            public function getStatusCode(): int
            {
                return 200;
            }

            public function setHeader(string $header, string $value): ResponseInterface
            {
                return $this;
            }

            public function getHeaders(): array
            {
                return [];
            }

            public function getHeader(string $header): string
            {
                return 'aaa';
            }

            public function getBody(): string
            {
                return 'holy moly';
            }

            public function isSuccessful(): bool
            {
                return true;
            }

            public function getDigest()
            {
                return null;
            }

            public function parseJSON(string $targetClass)
            {
                return null;
            }

            public function parseCsv(): CsvResponse
            {
                return $this->csvResponseMock;
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
        $this->assertInstanceOf(B2P::class, $gw->createB2P());
        $this->assertInstanceOf(InitRecurrentSms::class, $gw->createInitRecurrentSms());
        $this->assertInstanceOf(InitRecurrentDms::class, $gw->createInitRecurrentDms());
        $this->assertInstanceOf(RecurrentSms::class, $gw->createRecurrentSms());
        $this->assertInstanceOf(RecurrentDms::class, $gw->createRecurrentDms());
        $this->assertInstanceOf(Refund::class, $gw->createRefund());
        $this->assertInstanceOf(Reversal::class, $gw->createReversal());

        $this->assertInstanceOf(Result::class, $gw->createResult());
        $this->assertInstanceOf(History::class, $gw->createHistory());
        $this->assertInstanceOf(Status::class, $gw->createStatus());

        $this->assertInstanceOf(Enrolled3D::class, $gw->createVerify3dEnrollment());
        $this->assertInstanceOf(VerifyCard::class, $gw->createCardVerification());
        $this->assertInstanceOf(CreateToken::class, $gw->createToken());

        $gw->auth()
            ->setAccountGUID('dummy-guid')
            ->setSecretKey('dummy-key');

        $status = $gw->createStatus();
        $status->info()->setGatewayTransactionIDs(['example-key']);

        $req = $status->build();
        $res = $gw->process($req);
        $this->assertEquals('holy moly', $res->getBody());
        $this->assertEquals(200, $res->getStatusCode());
        $this->assertEquals('aaa', $res->getHeader('demo'));
        $this->assertEquals("{\"data\":{\"command-data\":{\"gateway-transaction-ids\":[\"example-key\"]}}}", $req->getPreparedData());
    }

    public function testGatewayException(): void
    {
        $this->expectException(GatewayException::class);

        $gw = new Gateway();

        $sms = $gw->createSms();
        $req = $sms->build();

        $gw->process($req);
    }

    public function testGenerateRequest(): void
    {
        $gw = new Gateway();

        $status = $gw->createStatus();
        $status->info()->setGatewayTransactionIDs(['example-key']);

        $req = $gw->generateRequest($status);

        $this->assertEquals('POST', $req->getMethod());
        $this->assertEquals('/status', $req->getPath());
        $this->assertEquals("{\"data\":{\"command-data\":{\"gateway-transaction-ids\":[\"example-key\"]}}}", $req->getPreparedData());
    }

    public function testGenerateRequestThrowException(): void
    {
        $this->expectException(ValidatorException::class);

        $gw = new Gateway();

        $status = $gw->createSms();

        $gw->generateRequest($status);
    }
}
