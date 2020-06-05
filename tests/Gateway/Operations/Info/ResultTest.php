<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations\Info;

use DateTime;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\DataSets\Info;
use TransactPro\Gateway\Http\Response;
use TransactPro\Gateway\Responses\Constants\Status as StatusCode;
use TransactPro\Gateway\Validator\Validator;

class ResultTest extends TestCase
{
    public function testSuccess()
    {
        $expected = [
            DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_IDS => ['123'],
            DataSet::COMMAND_DATA_MERCHANT_TRANSACTION_IDS => ['123'],
        ];

        $result = new Result(new Validator(), new Info());
        $result->info()
            ->setGatewayTransactionIDs(['123'])
            ->setMerchantTransactionIDs(['123']);

        $req = $result->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/result", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }

    public function testParseResultResponse()
    {
        $expectedDateCreated = DateTime::createFromFormat('Y-m-d H:i:s', "2020-06-10 08:37:22", new DateTimeZone('UTC'));
        $expectedDateFinished = DateTime::createFromFormat('Y-m-d H:i:s', "2020-06-10 08:37:23", new DateTimeZone('UTC'));

        $body = "{\"transactions\":[{\"date-created\":\"2020-06-10 08:37:22\",\"date-finished\":\"2020-06-10 08:37:23\"," .
            "\"gateway-transaction-id\":\"b552fe8c-0fe3-4982-b2d6-9c37fa96dc58\",\"result-data\":{\"acquirer-details\":" .
            "{\"eci-sli\":\"736\",\"result-code\":\"000\",\"status-description\":\"Approved\",\"status-text\":\"Approved\"," .
            "\"terminal-mid\":\"5800978\",\"transaction-id\":\"8225174463086463\"},\"error\":{},\"gw\":" .
            "{\"gateway-transaction-id\":\"b552fe8c-0fe3-4982-b2d6-9c37fa96dc58\",\"original-gateway-transaction-id\":" .
            "\"096a93f4-c4d9-4b46-bbe9-22e30031f2d2\",\"parent-gateway-transaction-id\":\"096a93f4-c4d9-4b46-bbe9-22e30031f2d2\"," .
            "\"status-code\":15,\"status-text\":\"CANCELLED\"}}},{\"error\":{\"code\":400,\"message\":" .
            "\"Failed to get transaction result for transaction with gateway id: 965ffd17-1874-48d0-89f3-f2c2f06bf749\"}," .
            "\"gateway-transaction-id\":\"965ffd17-1874-48d0-89f3-f2c2f06bf749\"}]}";

        $operation = new Result(new Validator(), new Info());
        $parsedResponse = $operation->parseResponse(new Response(200, $body));
        $this->assertEquals(2, count($parsedResponse->transactions));

        $tr1 = $parsedResponse->transactions[0];
        $this->assertEquals("b552fe8c-0fe3-4982-b2d6-9c37fa96dc58", $tr1->gatewayTransactionId);
        $this->assertEquals($expectedDateCreated, $tr1->dateCreated);
        $this->assertEquals($expectedDateFinished, $tr1->dateFinished);

        $this->assertNotNull($tr1->resultData->acquirerDetails);
        $this->assertEquals('', $tr1->resultData->acquirerDetails->dynamicDescriptor);
        $this->assertEquals("736", $tr1->resultData->acquirerDetails->eciSli);
        $this->assertEquals("000", $tr1->resultData->acquirerDetails->resultCode);
        $this->assertEquals("Approved", $tr1->resultData->acquirerDetails->statusDescription);
        $this->assertEquals("Approved", $tr1->resultData->acquirerDetails->statusText);
        $this->assertEquals("5800978", $tr1->resultData->acquirerDetails->terminalMid);
        $this->assertEquals("8225174463086463", $tr1->resultData->acquirerDetails->transactionId);

        $this->assertNotNull($tr1->resultData->gw);
        $this->assertEquals("b552fe8c-0fe3-4982-b2d6-9c37fa96dc58", $tr1->resultData->gw->gatewayTransactionId);
        $this->assertEquals("096a93f4-c4d9-4b46-bbe9-22e30031f2d2", $tr1->resultData->gw->originalGatewayTransactionId);
        $this->assertEquals("096a93f4-c4d9-4b46-bbe9-22e30031f2d2", $tr1->resultData->gw->parentGatewayTransactionId);
        $this->assertEquals(StatusCode::DMS_CANCELED_OK, $tr1->resultData->gw->statusCode);
        $this->assertEquals("CANCELLED", $tr1->resultData->gw->statusText);

        $tr2 = $parsedResponse->transactions[1];
        $this->assertEquals("965ffd17-1874-48d0-89f3-f2c2f06bf749", $tr2->gatewayTransactionId);
        $this->assertEquals(400, $tr2->error->code);
        $this->assertEquals("Failed to get transaction result for transaction with gateway id: 965ffd17-1874-48d0-89f3-f2c2f06bf749", $tr2->error->message);
    }
}
