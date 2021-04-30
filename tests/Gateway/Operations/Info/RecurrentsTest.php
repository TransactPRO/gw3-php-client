<?php

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

class RecurrentsTest extends TestCase
{
    public function testSuccess(): void
    {
        $expected = [
            DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_IDS => ['123'],
            DataSet::COMMAND_DATA_MERCHANT_TRANSACTION_IDS => ['123'],
        ];

        $status = new Recurrents(new Validator(), new Info());
        $status->info()
            ->setGatewayTransactionIDs(['123'])
            ->setMerchantTransactionIDs(['123']);

        $req = $status->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/recurrents", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }

    public function testParseRecurringTransactionsResponse(): void
    {
        $expectedDateFinished = DateTime::createFromFormat('Y-m-d H:i:s', "2020-06-09 09:56:53", new DateTimeZone('UTC'));

        $body = "{\"transactions\":[{\"error\":{\"code\":400,\"message\":\"Failed to fetch data for transaction with gateway id: " .
            "9e09bad0-5704-4b78-bf6a-c612f0101900\"},\"gateway-transaction-id\":\"9e09bad0-5704-4b78-bf6a-c612f0101900\"}," .
            "{\"gateway-transaction-id\":\"9e09bad0-5704-4b78-bf6a-c612f010192a\",\"recurrents\":[{\"account-guid\":" .
            "\"bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b\",\"account-id\":108,\"acq-terminal-id\":\"5800978\",\"acq-transaction-id\":" .
            "\"7435540948424227\",\"amount\":100,\"approval-code\":\"4773442\",\"cardholder-name\":\"John Doe\",\"currency\":\"EUR\"," .
            "\"date-finished\":\"2020-06-09 09:56:53\",\"eci-sli\":\"464\",\"gateway-transaction-id\":\"a2975c68-e235-40a4-87a9-987824c2090a\"," .
            "\"merchant-transaction-id\":\"52a9990bad03e15417c70ef11a8103e1\",\"status-code\":7,\"status-code-general\":13," .
            "\"status-text\":\"SUCCESS\",\"status-text-general\":\"REFUND SUCCESS\"}]}]}";

        $operation = new Recurrents(new Validator(), new Info());
        $parsedResponse = $operation->parseResponse(new Response(200, $body));
        $this->assertEquals(2, count($parsedResponse->transactions));

        $tr1 = $parsedResponse->transactions[0];
        $this->assertEquals("9e09bad0-5704-4b78-bf6a-c612f0101900", $tr1->gatewayTransactionId);
        $this->assertEquals(400, $tr1->error->code);
        $this->assertEquals("Failed to fetch data for transaction with gateway id: 9e09bad0-5704-4b78-bf6a-c612f0101900", $tr1->error->message);

        $tr2 = $parsedResponse->transactions[1];
        $this->assertEquals("9e09bad0-5704-4b78-bf6a-c612f010192a", $tr2->gatewayTransactionId);
        $this->assertEquals(1, count($tr2->subsequent));

        $info1 = $tr2->subsequent[0];
        $this->assertEquals("bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b", $info1->accountGuid);
        $this->assertEquals("5800978", $info1->acqTerminalId);
        $this->assertEquals("7435540948424227", $info1->acqTransactionId);
        $this->assertEquals(100, $info1->amount);
        $this->assertEquals("4773442", $info1->approvalCode);
        $this->assertEquals("John Doe", $info1->cardholderName);
        $this->assertEquals("EUR", $info1->currency);
        $this->assertEquals($expectedDateFinished, $info1->dateFinished);
        $this->assertEquals("464", $info1->eciSli);
        $this->assertEquals("a2975c68-e235-40a4-87a9-987824c2090a", $info1->gatewayTransactionId);
        $this->assertEquals("52a9990bad03e15417c70ef11a8103e1", $info1->merchantTransactionId);
        $this->assertEquals(StatusCode::SUCCESS, $info1->statusCode);
        $this->assertEquals(StatusCode::REFUND_SUCCESS, $info1->statusCodeGeneral);
        $this->assertEquals("SUCCESS", $info1->statusText);
        $this->assertEquals("REFUND SUCCESS", $info1->statusTextGeneral);
    }
}
