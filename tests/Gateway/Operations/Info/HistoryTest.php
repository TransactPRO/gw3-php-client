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

class HistoryTest extends TestCase
{
    public function testSuccess(): void
    {
        $expected = [
            DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_IDS => ['123'],
            DataSet::COMMAND_DATA_MERCHANT_TRANSACTION_IDS => ['123'],
        ];

        $history = new History(new Validator(), new Info());
        $history->info()
            ->setGatewayTransactionIDs(['123'])
            ->setMerchantTransactionIDs(['123']);

        $req = $history->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/history", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }

    public function testParseHistoryResponse(): void
    {
        $expectedDate1 = DateTime::createFromFormat('Y-m-d H:i:s', "2020-06-09 09:56:53", new DateTimeZone('UTC'));
        $expectedDate2 = DateTime::createFromFormat('Y-m-d H:i:s', "2020-06-09 09:57:53", new DateTimeZone('UTC'));

        $body = "{\"transactions\":[{\"error\":{\"code\":400,\"message\":\"Failed to fetch data for transaction with gateway id: " .
                "a2975c68-e235-40a4-87a9-987824c20000\"},\"gateway-transaction-id\":\"a2975c68-e235-40a4-87a9-987824c20000\"}," .
                "{\"gateway-transaction-id\":\"a2975c68-e235-40a4-87a9-987824c2090a\",\"history\":[{\"date-updated\":\"2020-06-09 09:56:53\"," .
                "\"status-code-new\":2,\"status-code-old\":1,\"status-text-new\":\"SENT TO BANK\",\"status-text-old\":\"INIT\"}," .
                "{\"date-updated\":\"2020-06-09 09:57:53\",\"status-code-new\":7,\"status-code-old\":2,\"status-text-new\":\"SUCCESS\"," .
                "\"status-text-old\":\"SENT TO BANK\"}]}]}";

        $history = new History(new Validator(), new Info());
        $parsedResponse = $history->parseResponse(new Response(200, $body));
        $this->assertEquals(2, count($parsedResponse->transactions));

        $tr1 = $parsedResponse->transactions[0];
        $this->assertEquals("a2975c68-e235-40a4-87a9-987824c20000", $tr1->gatewayTransactionId);
        $this->assertEquals(400, $tr1->error->code);
        $this->assertEquals("Failed to fetch data for transaction with gateway id: a2975c68-e235-40a4-87a9-987824c20000", $tr1->error->message);

        $tr2 = $parsedResponse->transactions[1];
        $this->assertEquals("a2975c68-e235-40a4-87a9-987824c2090a", $tr2->gatewayTransactionId);
        $this->assertEquals(2, count($tr2->history));

        $event1 = $tr2->history[0];
        $this->assertEquals($expectedDate1, $event1->dateUpdated);
        $this->assertEquals(StatusCode::INIT, $event1->statusCodeOld);
        $this->assertEquals(StatusCode::SENT2BANK, $event1->statusCodeNew);
        $this->assertEquals("INIT", $event1->statusTextOld);
        $this->assertEquals("SENT TO BANK", $event1->statusTextNew);

        $event2 = $tr2->history[1];
        $this->assertEquals($expectedDate2, $event2->dateUpdated);
        $this->assertEquals(StatusCode::SENT2BANK, $event2->statusCodeOld);
        $this->assertEquals(StatusCode::SUCCESS, $event2->statusCodeNew);
        $this->assertEquals("SENT TO BANK", $event2->statusTextOld);
        $this->assertEquals("SUCCESS", $event2->statusTextNew);
    }
}
