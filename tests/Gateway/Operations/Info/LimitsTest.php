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
use TransactPro\Gateway\Http\Response;
use TransactPro\Gateway\Validator\Validator;

class LimitsTest extends TestCase
{
    public function testSuccess(): void
    {
        $expected = [];

        $status = new Limits(new Validator());
        $req = $status->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/limits", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }

    public function testParseLimitsResponse(): void
    {
        $body = "{\"childs\":[{\"childs\":[{\"childs\":[{\"counters\":[{\"counter-type\":\"TR_SUCCESS_AMOUNT\",\"currency\":\"EUR\"," .
            "\"limit\":5000000,\"payment-method-subtype\":\"all\",\"payment-method-type\":\"all\",\"value\":28410}," .
            "{\"counter-type\":\"TR_SUCCESS_COUNT\",\"currency\":\"EUR\",\"limit\":20000,\"payment-method-subtype\":\"all\"," .
            "\"payment-method-type\":\"all\",\"value\":992}],\"acq-terminal-id\":\"5800978\",\"title\":\"Test T1\",\"type\":\"terminal\"}]," .
            "\"counters\":[{\"counter-type\":\"TR_SUCCESS_AMOUNT\",\"currency\":\"EUR\",\"limit\":5000000,\"payment-method-subtype\":\"all\"," .
            "\"payment-method-type\":\"all\",\"value\":2400}],\"title\":\"Test TG\",\"type\":\"terminal-group\"}],\"counters\":" .
            "[{\"counter-type\":\"TR_SUCCESS_AMOUNT\",\"currency\":\"EUR\",\"limit\":5000000,\"payment-method-subtype\":\"all\"," .
            "\"payment-method-type\":\"all\",\"value\":2400}],\"title\":\"Test ACC\",\"type\":\"account\"}],\"counters\":" .
            "[{\"counter-type\":\"TR_SUCCESS_AMOUNT\",\"currency\":\"EUR\",\"limit\":5000000,\"payment-method-subtype\":\"all\"," .
            "\"payment-method-type\":\"all\",\"value\":2400}],\"title\":\"Test M\",\"type\":\"merchant\"}";

        $operation = new Limits(new Validator());
        $parsedResponse = $operation->parseResponse(new Response(200, $body));

        $merchant = $parsedResponse->limits;
        $this->assertEquals("merchant", $merchant->type);
        $this->assertEquals("Test M", $merchant->title);
        $this->assertEquals('', $merchant->acqTerminalId);
        $this->assertEquals(1, count($merchant->children));
        $this->assertEquals(1, count($merchant->limits));
        $this->assertEquals("TR_SUCCESS_AMOUNT", $merchant->limits[0]->counterType);
        $this->assertEquals("EUR", $merchant->limits[0]->currency);
        $this->assertEquals(5000000, $merchant->limits[0]->limit);
        $this->assertEquals(2400, $merchant->limits[0]->value);
        $this->assertEquals("all", $merchant->limits[0]->paymentMethodType);
        $this->assertEquals("all", $merchant->limits[0]->paymentMethodSubtype);

        $account = $merchant->children[0];
        $this->assertEquals("account", $account->type);
        $this->assertEquals("Test ACC", $account->title);
        $this->assertEquals('', $account->acqTerminalId);
        $this->assertEquals(1, count($account->children));
        $this->assertEquals(1, count($account->limits));
        $this->assertEquals("TR_SUCCESS_AMOUNT", $account->limits[0]->counterType);
        $this->assertEquals("EUR", $account->limits[0]->currency);
        $this->assertEquals(5000000, $account->limits[0]->limit);
        $this->assertEquals(2400, $account->limits[0]->value);
        $this->assertEquals("all", $account->limits[0]->paymentMethodType);
        $this->assertEquals("all", $account->limits[0]->paymentMethodSubtype);

        $terminalGroup = $account->children[0];
        $this->assertEquals("terminal-group", $terminalGroup->type);
        $this->assertEquals("Test TG", $terminalGroup->title);
        $this->assertEquals('', $terminalGroup->acqTerminalId);
        $this->assertEquals(1, count($terminalGroup->children));
        $this->assertEquals(1, count($terminalGroup->limits));
        $this->assertEquals("TR_SUCCESS_AMOUNT", $terminalGroup->limits[0]->counterType);
        $this->assertEquals("EUR", $terminalGroup->limits[0]->currency);
        $this->assertEquals(5000000, $terminalGroup->limits[0]->limit);
        $this->assertEquals(2400, $terminalGroup->limits[0]->value);
        $this->assertEquals("all", $terminalGroup->limits[0]->paymentMethodType);
        $this->assertEquals("all", $terminalGroup->limits[0]->paymentMethodSubtype);

        $terminal = $terminalGroup->children[0];
        $this->assertEquals("terminal", $terminal->type);
        $this->assertEquals("Test T1", $terminal->title);
        $this->assertEquals("5800978", $terminal->acqTerminalId);
        $this->assertEquals(0, count($terminal->children));
        $this->assertEquals(2, count($terminal->limits));

        $this->assertEquals("TR_SUCCESS_AMOUNT", $terminal->limits[0]->counterType);
        $this->assertEquals("EUR", $terminal->limits[0]->currency);
        $this->assertEquals(5000000, $terminal->limits[0]->limit);
        $this->assertEquals(28410, $terminal->limits[0]->value);
        $this->assertEquals("all", $terminal->limits[0]->paymentMethodType);
        $this->assertEquals("all", $terminal->limits[0]->paymentMethodSubtype);

        $this->assertEquals("TR_SUCCESS_COUNT", $terminal->limits[1]->counterType);
        $this->assertEquals("EUR", $terminal->limits[1]->currency);
        $this->assertEquals(20000, $terminal->limits[1]->limit);
        $this->assertEquals(992, $terminal->limits[1]->value);
        $this->assertEquals("all", $terminal->limits[1]->paymentMethodType);
        $this->assertEquals("all", $terminal->limits[1]->paymentMethodSubtype);
    }
}
