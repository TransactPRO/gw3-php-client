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

class CreditTest extends TestCase
{
    public function testCreditSuccess()
    {
        $expected = [
            DataSet::PAYMENT_METHOD_DATA_PAN => 'qwe123',
            DataSet::PAYMENT_METHOD_DATA_EXPIRE => '12/21',
            DataSet::MONEY_DATA_AMOUNT => 100,
            DataSet::MONEY_DATA_CURRENCY => 'USD',
        ];

        $order = new Credit(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System());
        $order->paymentMethod()
            ->setPAN('qwe123')
            ->setExpire('12/21');
        $order->money()
            ->setAmount(100)
            ->setCurrency('USD');

        $raw = $order->build();

        $this->assertEquals("POST", $raw->getMethod());
        $this->assertEquals("/credit", $raw->getPath());
        $this->assertEquals($expected, $raw->getData());
    }

    public function testCreditValidatorException()
    {
        $this->expectException(ValidatorException::class);

        $order = new Credit(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System());

        $order->build();
    }

    public function testCreditInsideForm()
    {
        $order = new Credit(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System());
        $order->money()
            ->setAmount(100)
            ->setCurrency('EUR');

        $raw = $order->insideForm()->build();

        $this->assertEquals($raw->getPath(), '/credit');
    }
}
