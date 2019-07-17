<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations\Token;

use PHPUnit\Framework\TestCase;
use TransactPro\Gateway\DataSets\Command;
use TransactPro\Gateway\DataSets\Customer;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\DataSets\Money;
use TransactPro\Gateway\DataSets\Order;
use TransactPro\Gateway\DataSets\PaymentMethod;
use TransactPro\Gateway\DataSets\System;
use TransactPro\Gateway\Exceptions\ValidatorException;
use TransactPro\Gateway\Validator\Validator;

class CreateTokenTest extends TestCase
{
    public function testCreateTokenSuccess()
    {
        $expected = [
            DataSet::PAYMENT_METHOD_DATA_PAN => 'qwe123',
            DataSet::PAYMENT_METHOD_DATA_EXPIRE => '12/21',
            DataSet::PAYMENT_METHOD_DATA_CARDHOLDER_NAME => 'John Doe',
            DataSet::MONEY_DATA_CURRENCY => 'USD',
        ];

        $sms = new CreateToken(new Validator(), new PaymentMethod(), new Money(), new Order(), new System(), new Command());
        $sms->paymentMethod()
            ->setPAN('qwe123')
            ->setExpire('12/21')
            ->setCardHolderName('John Doe');
        $sms->money()
            ->setCurrency('USD');

        $raw = $sms->build();

        $this->assertEquals("POST", $raw->getMethod());
        $this->assertEquals("/token/create", $raw->getPath());
        $this->assertEquals($expected, $raw->getData());
    }

    public function testCreateTokenValidatorException()
    {
        $this->expectException(ValidatorException::class);

        $sms = new CreateToken(new Validator(), new PaymentMethod(), new Money(), new Order(), new System(), new Command());

        $sms->build();
    }
}