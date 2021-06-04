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

use PHPUnit\Framework\TestCase;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\DataSets\Info;
use TransactPro\Gateway\Http\Response;
use TransactPro\Gateway\Responses\Constants\Status as StatusCode;
use TransactPro\Gateway\Validator\Validator;

class StatusTest extends TestCase
{
    public function testSuccess(): void
    {
        $expected = [
            DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_IDS => ['123'],
            DataSet::COMMAND_DATA_MERCHANT_TRANSACTION_IDS => ['123'],
        ];

        $status = new Status(new Validator(), new Info());
        $status->info()
            ->setGatewayTransactionIDs(['123'])
            ->setMerchantTransactionIDs(['123']);

        $req = $status->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/status", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }

    public function testParseStatusResponse(): void
    {
        $body = "{\"transactions\":[{\"gateway-transaction-id\":\"cd7b8bdf-3c78-4540-95d0-68018d2aba97\",\"status\":" .
            "[{\"gateway-transaction-id\":\"cd7b8bdf-3c78-4540-95d0-68018d2aba97\",\"status-code\":7,\"status-code-general\":8," .
            "\"status-text\":\"SUCCESS\",\"status-text-general\":\"EXPIRED\"}]},{\"gateway-transaction-id\":\"37908991-789b-4d79-8c6a-f90ba0ce12b6\"," .
            "\"status\":[{\"gateway-transaction-id\":\"37908991-789b-4d79-8c6a-f90ba0ce12b6\",\"status-code\":8,\"status-code-general\":7," .
            "\"status-text\":\"EXPIRED\",\"status-text-general\":\"SUCCESS\"}]}," .
            "{\"error\":{\"code\":400,\"message\":\"Failed to fetch data for transaction with gateway id: 99900000-789b-4d79-8c6a-f90ba0ce12b0\"}," .
            "\"gateway-transaction-id\":\"99900000-789b-4d79-8c6a-f90ba0ce12b0\"}]}";

        $operation = new Status(new Validator(), new Info());
        $parsedResponse = $operation->parseResponse(new Response(200, $body));
        $this->assertEquals(3, count($parsedResponse->transactions));

        $tr1 = $parsedResponse->transactions[0];
        $this->assertEquals("cd7b8bdf-3c78-4540-95d0-68018d2aba97", $tr1->gatewayTransactionId);
        $this->assertEquals(StatusCode::SUCCESS, $tr1->statusCode);
        $this->assertEquals(StatusCode::EXPIRED, $tr1->statusCodeGeneral);
        $this->assertEquals("SUCCESS", $tr1->statusText);
        $this->assertEquals("EXPIRED", $tr1->statusTextGeneral);

        $tr2 = $parsedResponse->transactions[1];
        $this->assertEquals("37908991-789b-4d79-8c6a-f90ba0ce12b6", $tr2->gatewayTransactionId);
        $this->assertEquals(StatusCode::EXPIRED, $tr2->statusCode);
        $this->assertEquals(StatusCode::SUCCESS, $tr2->statusCodeGeneral);
        $this->assertEquals("EXPIRED", $tr2->statusText);
        $this->assertEquals("SUCCESS", $tr2->statusTextGeneral);

        $tr3 = $parsedResponse->transactions[2];
        $this->assertEquals("99900000-789b-4d79-8c6a-f90ba0ce12b0", $tr3->gatewayTransactionId);
        $this->assertEquals(400, $tr3->error->code);
        $this->assertEquals("Failed to fetch data for transaction with gateway id: 99900000-789b-4d79-8c6a-f90ba0ce12b0", $tr3->error->message);
    }
}
