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
use TransactPro\Gateway\DataSets\Customer;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\DataSets\Money;
use TransactPro\Gateway\DataSets\Order;
use TransactPro\Gateway\DataSets\PaymentMethod;
use TransactPro\Gateway\DataSets\System;
use TransactPro\Gateway\Exceptions\ValidatorException;
use TransactPro\Gateway\Http\Response;
use TransactPro\Gateway\Responses\Constants\ErrorCode;
use TransactPro\Gateway\Responses\Constants\Status;
use TransactPro\Gateway\Validator\Validator;

class SmsTest extends TestCase
{
    public function testSmsSuccess()
    {
        $expected = [
            DataSet::PAYMENT_METHOD_DATA_PAN => 'qwe123',
            DataSet::PAYMENT_METHOD_DATA_EXPIRE => '12/21',
            DataSet::PAYMENT_METHOD_DATA_CVV => '123',
            DataSet::MONEY_DATA_AMOUNT => 100,
            DataSet::MONEY_DATA_CURRENCY => 'USD',
        ];

        $sms = new Sms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
        $sms->paymentMethod()
            ->setPAN('qwe123')
            ->setExpire('12/21')
            ->setCVV('123');
        $sms->money()
            ->setAmount(100)->setCurrency('USD');

        $raw = $sms->build();

        $this->assertEquals("POST", $raw->getMethod());
        $this->assertEquals("/sms", $raw->getPath());
        $this->assertEquals($expected, $raw->getData());
    }

    public function testSmsValidatorException()
    {
        $this->expectException(ValidatorException::class);

        $sms = new Sms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());

        $sms->build();
    }

    public function testSmsInsideForm()
    {
        $sms = new Sms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
        $sms->money()
            ->setAmount(100)
            ->setCurrency('EUR');

        $raw = $sms->insideForm()->build();

        $this->assertEquals($raw->getPath(), '/sms');
    }

    public function testSmsUseToken()
    {
        $sms = new Sms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
        $sms->command()
            ->setPaymentMethodDataToken('test-tr-id')
            ->setPaymentMethodDataSource(Command::DATA_SOURCE_USE_GATEWAY_SAVED_CARDHOLDER_INITIATED);
        $sms->money()
            ->setAmount(100)
            ->setCurrency('EUR');

        $raw = $sms->useToken()->build();

        $this->assertEquals($raw->getPath(), '/sms');
    }

    public function testParsePaymentResponseSuccessfulAPI()
    {
        $body = "{\"acquirer-details\":{\"dynamic-descriptor\":\"test\",\"eci-sli\":\"648\",\"result-code\":\"000\",\"status-description\":\"Approved\"," .
            "\"status-text\":\"Approved\",\"terminal-mid\":\"5800978\",\"transaction-id\":\"1899493845214315\"},\"error\":{}," .
            "\"gw\":{\"gateway-transaction-id\":\"8a9bed66-8412-494f-9866-2c26b5ceee62\",\"merchant-transaction-id\":\"87d53472ba27fde33ec03e2f5ca6137a\",".
            "\"status-code\":7,\"status-text\":\"SUCCESS\",\"original-gateway-transaction-id\":\"orig-aaa\",\"parent-gateway-transaction-id\":\"parent-aaa\"}," .
            "\"warnings\":[\"Soon counters will be exceeded for the merchant\",\"Soon counters will be exceeded for the account\"," .
            "\"Soon counters will be exceeded for the terminal group\",\"Soon counters will be exceeded for the terminal\"]}\n";

        $sms = new Sms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
        $parsedResponse = $sms->parseResponse(new Response(200, $body));

        $this->assertNotNull($parsedResponse->acquirerDetails);
        $this->assertEquals("test", $parsedResponse->acquirerDetails->dynamicDescriptor);
        $this->assertEquals("648", $parsedResponse->acquirerDetails->eciSli);
        $this->assertEquals("000", $parsedResponse->acquirerDetails->resultCode);
        $this->assertEquals("Approved", $parsedResponse->acquirerDetails->statusDescription);
        $this->assertEquals("Approved", $parsedResponse->acquirerDetails->statusText);
        $this->assertEquals("5800978", $parsedResponse->acquirerDetails->terminalMid);
        $this->assertEquals("1899493845214315", $parsedResponse->acquirerDetails->transactionId);

        $this->assertNotNull($parsedResponse->gw);
        $this->assertEquals("8a9bed66-8412-494f-9866-2c26b5ceee62", $parsedResponse->gw->gatewayTransactionId);
        $this->assertEquals("87d53472ba27fde33ec03e2f5ca6137a", $parsedResponse->gw->merchantTransactionId);
        $this->assertEquals("orig-aaa", $parsedResponse->gw->originalGatewayTransactionId);
        $this->assertEquals("parent-aaa", $parsedResponse->gw->parentGatewayTransactionId);
        $this->assertEquals(Status::SUCCESS, $parsedResponse->gw->statusCode);
        $this->assertEquals("SUCCESS", $parsedResponse->gw->statusText);

        $expectedWarnings = [
            "Soon counters will be exceeded for the merchant",
            "Soon counters will be exceeded for the account",
            "Soon counters will be exceeded for the terminal group",
            "Soon counters will be exceeded for the terminal",
        ];
        $this->assertEquals($expectedWarnings, $parsedResponse->warnings);
    }

    public function testParsePaymentResponseSuccessfulRedirect() {
        $body = "{\"acquirer-details\": {},\"error\": {},\"gw\": {\"gateway-transaction-id\": \"965ffd17-1874-48d0-89f3-f2c2f06bf749\"," .
                "\"redirect-url\": \"https://api.url/a4345be5b8a1af9773b8b0642b49ff26\",\"status-code\": 30,\"status-text\": \"INSIDE FORM URL SENT\"}}";

        $sms = new Sms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
        $parsedResponse = $sms->parseResponse(new Response(200, $body));

        $this->assertNotNull($parsedResponse->gw);
        $this->assertEquals("965ffd17-1874-48d0-89f3-f2c2f06bf749", $parsedResponse->gw->gatewayTransactionId);
        $this->assertEquals("https://api.url/a4345be5b8a1af9773b8b0642b49ff26", $parsedResponse->gw->redirectUrl);
        $this->assertEquals(Status::CARD_FORM_URL_SENT, $parsedResponse->gw->statusCode);
        $this->assertEquals("INSIDE FORM URL SENT", $parsedResponse->gw->statusText);
    }

    public function testParsePaymentResponseError() {
        $body = "{\"acquirer-details\": {},\"error\": {\"code\": 1102,\"message\": \"Invalid pan number. Failed assertion that pan (false) == true\"}," .
            "\"gw\":{\"gateway-transaction-id\": \"33f17d34-3796-45e0-9bba-a771e9d3e504\",\"status-code\": 19,\"status-text\": \"BR VALIDATION FAILED\"}," .
            "\"warnings\": [\"Soon counters will be exceeded for the merchant\",\"Soon counters will be exceeded for the account\"]}";

        $sms = new Sms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System(), new Command());
        $parsedResponse = $sms->parseResponse(new Response(200, $body));

        $this->assertNotNull($parsedResponse->error);
        $this->assertEquals(ErrorCode::EEC_CC_BAD_NUMBER, $parsedResponse->error->code);
        $this->assertEquals("Invalid pan number. Failed assertion that pan (false) == true", $parsedResponse->error->message);

        $this->assertNotNull($parsedResponse->gw);
        $this->assertEquals("33f17d34-3796-45e0-9bba-a771e9d3e504", $parsedResponse->gw->gatewayTransactionId);
        $this->assertEquals(Status::BR_VALIDATION_FAILED, $parsedResponse->gw->statusCode);
        $this->assertEquals("BR VALIDATION FAILED", $parsedResponse->gw->statusText);

        $expectedWarnings = [
            "Soon counters will be exceeded for the merchant",
            "Soon counters will be exceeded for the account",
        ];
        $this->assertEquals($expectedWarnings, $parsedResponse->warnings);
    }
}
