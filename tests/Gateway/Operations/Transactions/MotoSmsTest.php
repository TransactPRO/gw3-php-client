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
use TransactPro\Gateway\Exceptions\ValidatorException;
use TransactPro\Gateway\Validator\Validator;

class MotoSmsTest extends TestCase
{
    public function testMotoSmsSuccess()
    {
        $expected = [
            DataSet::PAYMENT_METHOD_DATA_PAN => '123',
            DataSet::PAYMENT_METHOD_DATA_EXPIRE => '12/21',
            DataSet::MONEY_DATA_AMOUNT => 100,
            DataSet::MONEY_DATA_CURRENCY => 'USD',
        ];

        $motoSms = new MotoSms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System());
        $motoSms->money()->setAmount(100)->setCurrency('USD');
        $motoSms->paymentMethod()->setPAN('123')->setExpire('12/21');

        $raw = $motoSms->build();

        $this->assertEquals("POST", $raw->getMethod());
        $this->assertEquals("/moto/sms", $raw->getPath());
        $this->assertEquals($expected, $raw->getData());
    }

    public function testMotoSmsValidatorException()
    {
        $this->expectException(ValidatorException::class);

        $motoSms = new MotoSms(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System());

        $motoSms->build();
    }
}
