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
use TransactPro\Gateway\DataSets\Customer;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\DataSets\Money;
use TransactPro\Gateway\DataSets\Order;
use TransactPro\Gateway\DataSets\PaymentMethod;
use TransactPro\Gateway\DataSets\System;
use TransactPro\Gateway\Validator\Validator;

class InitRecurrentDmsTest extends TestCase
{
    public function testInitRecurrentDmsHoldSuccess()
    {
        $expected = [
            DataSet::PAYMENT_METHOD_DATA_PAN => '123',
            DataSet::PAYMENT_METHOD_DATA_CVV => '123',
            DataSet::PAYMENT_METHOD_DATA_EXPIRE => '12/21',
            DataSet::MONEY_DATA_AMOUNT => 100,
            DataSet::MONEY_DATA_CURRENCY => 'USD',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_EMAIL => 'demo@example.com',
            DataSet::GENERAL_DATA_ORDER_DATA_ORDER_ID => 'order',
            DataSet::SYSTEM_USER_IP => '127.0.0.1',
        ];

        $dms = new InitRecurrentDms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System());

        $dms->paymentMethod()->setPAN('123')
            ->setCVV('123')
            ->setExpire('12/21');

        $dms->money()->setAmount(100)
            ->setCurrency('USD');

        $dms->customer()->setEmail('demo@example.com');

        $dms->order()->setID('order');

        $dms->system()->setUserIP('127.0.0.1');

        $req = $dms->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/recurrent/dms/init", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }
}
