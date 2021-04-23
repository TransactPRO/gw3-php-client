<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations\Transactions;

use PHPUnit\Framework\TestCase;
use TransactPro\Gateway\DataSets\Command;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\DataSets\Order;
use TransactPro\Gateway\Exceptions\ValidatorException;
use TransactPro\Gateway\Http\Response;
use TransactPro\Gateway\Responses\Constants\Status;
use TransactPro\Gateway\Validator\Validator;

class CancelTest extends TestCase
{
    public function testCancelSuccess()
    {
        $expected = [
            DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_ID => "qwe",
            DataSet::COMMAND_DATA_FORM_ID => "zxc",
            DataSet::COMMAND_DATA_TERMINAL_MID => "asd",
            DataSet::GENERAL_DATA_ORDER_DATA_MERCHANT_TRANSACTION_ID => "ytrewq",
        ];

        $cancel = new Cancel(new Validator(), new Command(), new Order());

        $cancel->command()
            ->setGatewayTransactionID("qwe")
            ->setFormID("zxc")
            ->setTerminalMID("asd");

        $cancel->order()
            ->setMerchantTransactionID("ytrewq");

        $req = $cancel->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/cancel", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }

    public function testCancelValidatorException()
    {
        $this->expectException(ValidatorException::class);

        $cancel = new Cancel(new Validator(), new Command(), new Order());

        $cancel->command()
            ->setFormID("zxc")
            ->setTerminalMID("asd");

        $cancel->build();
    }

    public function testParsePaymentResponseSuccessfulRedirect()
    {
        $body = "{\"acquirer-details\": {},\"error\": {},\"gw\": {\"gateway-transaction-id\": \"965ffd17-1874-48d0-89f3-f2c2f06bf749\"," .
            "\"redirect-url\": \"https://api.url/a4345be5b8a1af9773b8b0642b49ff26\",\"status-code\": 30,\"status-text\": \"INSIDE FORM URL SENT\"}}";

        $operation = new Cancel(new Validator(), new Command(), new Order());
        $parsedResponse = $operation->parseResponse(new Response(200, $body));

        $this->assertNotNull($parsedResponse->gw);
        $this->assertEquals("965ffd17-1874-48d0-89f3-f2c2f06bf749", $parsedResponse->gw->gatewayTransactionId);
        $this->assertEquals("https://api.url/a4345be5b8a1af9773b8b0642b49ff26", $parsedResponse->gw->redirectUrl);
        $this->assertEquals(Status::CARD_FORM_URL_SENT, $parsedResponse->gw->statusCode);
        $this->assertEquals("INSIDE FORM URL SENT", $parsedResponse->gw->statusText);
    }
}
