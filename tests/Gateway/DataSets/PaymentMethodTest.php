<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\DataSets;

use PHPUnit\Framework\TestCase;

class PaymentMethodTest extends TestCase
{
    public function testSuccess()
    {
        $expected = [
            DataSet::PAYMENT_METHOD_DATA_PAN => '123123',
            DataSet::PAYMENT_METHOD_DATA_CVV => '123',
            DataSet::PAYMENT_METHOD_DATA_EXPIRE => '12/21',
            DataSet::PAYMENT_METHOD_DATA_CARDHOLDER_NAME => 'John Doe',
        ];

        $paymentMethod = new PaymentMethod();
        $raw = $paymentMethod
            ->setPAN('123123')
            ->setCVV('123')
            ->setExpire('12/21')
            ->setCardHolderName('John Doe')
            ->getRaw();

        $this->assertEquals($expected, $raw);
    }
}
