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

class P2PTest extends TestCase
{
    public function testP2PSuccess()
    {
        $expected = [
            DataSet::PAYMENT_METHOD_DATA_PAN => 'qwe123',
            DataSet::PAYMENT_METHOD_DATA_EXPIRE => '12/21',
            DataSet::MONEY_DATA_AMOUNT => 100,
            DataSet::MONEY_DATA_CURRENCY => 'USD',
            DataSet::GENERAL_DATA_ORDER_DATA_RECIPIENT_NAME => 'TEST RECIPIENT',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_BIRTH_DATE => '01021900',
        ];

        $order = new P2P(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System());
        $order->paymentMethod()
            ->setPAN('qwe123')
            ->setExpire('12/21');
        $order->money()
            ->setAmount(100)
            ->setCurrency('USD');
        $order->order()
            ->setRecipientName('TEST RECIPIENT');
        $order->customer()
            ->setBirthDate('01021900');

        $raw = $order->build();

        $this->assertEquals("POST", $raw->getMethod());
        $this->assertEquals("/p2p", $raw->getPath());
        $this->assertEquals($expected, $raw->getData());
    }

    public function testP2PValidatorException()
    {
        $this->expectException(ValidatorException::class);

        $order = new P2P(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System());

        $order->build();
    }

    public function testP2PInsideForm()
    {
        $order = new P2P(new Validator(), new PaymentMethod(), new Money(), new Customer(), new Order(), new System());
        $order->money()
            ->setAmount(100)
            ->setCurrency('EUR');
        $order->order()
            ->setRecipientName('TEST RECIPIENT');
        $order->customer()
            ->setBirthDate('01021900');

        $raw = $order->insideForm()->build();

        $this->assertEquals($raw->getPath(), '/p2p');
    }
}
