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

class RefundsTest extends TestCase
{
    public function testSuccess()
    {
        $expected = [
            DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_IDS => ['123'],
            DataSet::COMMAND_DATA_MERCHANT_TRANSACTION_IDS => ['123'],
        ];

        $refunds = new Refunds(new Validator(), new Info());
        $refunds->info()
            ->setGatewayTransactionIDs(['123'])
            ->setMerchantTransactionIDs(['123']);

        $req = $refunds->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/refunds", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }

    public function testParseRefundsResponse()
    {
        $expectedDateFinished1 = DateTime::createFromFormat('Y-m-d H:i:s', "2020-06-09 10:18:15", new DateTimeZone('UTC'));
        $expectedDateFinished2 = DateTime::createFromFormat('Y-m-d H:i:s', "2020-06-09 10:18:22", new DateTimeZone('UTC'));

        $body = "{\"transactions\":[{\"gateway-transaction-id\":\"a2975c68-e235-40a4-87a9-987824c2090a\",\"refunds\":" .
            "[{\"account-guid\":\"bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b\",\"account-id\":108,\"acq-terminal-id\":\"5800978\"," .
            "\"acq-transaction-id\":\"1128894405863338\",\"amount\":10,\"approval-code\":\"1299034\",\"cardholder-name\":\"John Doe\"," .
            "\"currency\":\"EUR\",\"date-finished\":\"2020-06-09 10:18:15\",\"eci-sli\":\"960\",\"gateway-transaction-id\":" .
            "\"508fd8b9-3f78-486b-812b-2756f44e1bc6\",\"merchant-transaction-id\":\"aaa1\",\"status-code\":13,\"status-code-general\":11," .
            "\"status-text\":\"REFUND SUCCESS\",\"status-text-general\":\"REFUND FAILED\"},{\"account-guid\":" .
            "\"bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b\",\"account-id\":108,\"acq-terminal-id\":\"5800978\",\"acq-transaction-id\":" .
            "\"0508080614087693\",\"amount\":20,\"approval-code\":\"7117603\",\"cardholder-name\":\"John Doe\",\"currency\":\"EUR\"," .
            "\"date-finished\":\"2020-06-09 10:18:22\",\"eci-sli\":\"690\",\"gateway-transaction-id\":\"191228b8-fd2d-47c8-8ff7-d28ba799cdb4\"," .
            "\"merchant-transaction-id\":\"\",\"status-code\":13,\"status-code-general\":13,\"status-text\":\"REFUND SUCCESS\"," .
            "\"status-text-general\":\"REFUND SUCCESS\"}]},{\"error\":{\"code\":400,\"message\":" .
            "\"Failed to fetch data for transaction with gateway id: a2975c68-e235-40a4-87a9-987824c20900\"}," .
            "\"gateway-transaction-id\":\"a2975c68-e235-40a4-87a9-987824c20900\"}]}";

        $operation = new Refunds(new Validator(), new Info());
        $parsedResponse = $operation->parseResponse(new Response(200, $body));
        $this->assertEquals(2, count($parsedResponse->transactions));

        $tr1 = $parsedResponse->transactions[0];
        $this->assertEquals("a2975c68-e235-40a4-87a9-987824c2090a", $tr1->gatewayTransactionId);
        $this->assertEquals(2, count($tr1->refunds));

        $refund1 = $tr1->refunds[0];
        $this->assertEquals("bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b", $refund1->accountGuid);
        $this->assertEquals("5800978", $refund1->acqTerminalId);
        $this->assertEquals("1128894405863338", $refund1->acqTransactionId);
        $this->assertEquals(10, $refund1->amount);
        $this->assertEquals("1299034", $refund1->approvalCode);
        $this->assertEquals("John Doe", $refund1->cardholderName);
        $this->assertEquals("EUR", $refund1->currency);
        $this->assertEquals($expectedDateFinished1, $refund1->dateFinished);
        $this->assertEquals("960", $refund1->eciSli);
        $this->assertEquals("508fd8b9-3f78-486b-812b-2756f44e1bc6", $refund1->gatewayTransactionId);
        $this->assertEquals("aaa1", $refund1->merchantTransactionId);
        $this->assertEquals(StatusCode::REFUND_SUCCESS, $refund1->statusCode);
        $this->assertEquals(StatusCode::REFUND_FAILED, $refund1->statusCodeGeneral);
        $this->assertEquals("REFUND SUCCESS", $refund1->statusText);
        $this->assertEquals("REFUND FAILED", $refund1->statusTextGeneral);

        $refund2 = $tr1->refunds[1];
        $this->assertEquals("bc501eda-e2a1-4e63-9a1e-7a7f6ff4813b", $refund2->accountGuid);
        $this->assertEquals("5800978", $refund2->acqTerminalId);
        $this->assertEquals("0508080614087693", $refund2->acqTransactionId);
        $this->assertEquals(20, $refund2->amount);
        $this->assertEquals("7117603", $refund2->approvalCode);
        $this->assertEquals("John Doe", $refund2->cardholderName);
        $this->assertEquals("EUR", $refund2->currency);
        $this->assertEquals($expectedDateFinished2, $refund2->dateFinished);
        $this->assertEquals("690", $refund2->eciSli);
        $this->assertEquals("191228b8-fd2d-47c8-8ff7-d28ba799cdb4", $refund2->gatewayTransactionId);
        $this->assertEquals("", $refund2->merchantTransactionId);
        $this->assertEquals(StatusCode::REFUND_SUCCESS, $refund2->statusCode);
        $this->assertEquals(StatusCode::REFUND_SUCCESS, $refund2->statusCodeGeneral);
        $this->assertEquals("REFUND SUCCESS", $refund2->statusText);
        $this->assertEquals("REFUND SUCCESS", $refund2->statusTextGeneral);

        $tr2 = $parsedResponse->transactions[1];
        $this->assertEquals("a2975c68-e235-40a4-87a9-987824c20900", $tr2->gatewayTransactionId);
        $this->assertEquals(400, $tr2->error->code);
        $this->assertEquals("Failed to fetch data for transaction with gateway id: a2975c68-e235-40a4-87a9-987824c20900", $tr2->error->message);
    }
}
