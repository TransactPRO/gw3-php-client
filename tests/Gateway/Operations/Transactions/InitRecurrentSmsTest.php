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

class InitRecurrentSmsTest extends TestCase
{
    public function testInitRecurrentSmsSuccess()
    {
        $expected = [
            DataSet::PAYMENT_METHOD_DATA_PAN => 'qwe123',
            DataSet::PAYMENT_METHOD_DATA_EXPIRE => '12/21',
            DataSet::PAYMENT_METHOD_DATA_CVV => '123',
            DataSet::MONEY_DATA_AMOUNT => 100,
            DataSet::MONEY_DATA_CURRENCY => 'USD',
        ];

        $sms = new InitRecurrentSms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System());
        $sms->paymentMethod()
            ->setPAN('qwe123')
            ->setExpire('12/21')
            ->setCVV('123');
        $sms->money()
            ->setAmount(100)->setCurrency('USD');

        $raw = $sms->build();

        $this->assertEquals("POST", $raw->getMethod());
        $this->assertEquals("/recurrent/sms/init", $raw->getPath());
        $this->assertEquals($expected, $raw->getData());
    }
}
