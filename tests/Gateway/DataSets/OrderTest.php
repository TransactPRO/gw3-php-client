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

class OrderTest extends TestCase
{
    public function testSuccess()
    {
        $expected = [
            DataSet::GENERAL_DATA_ORDER_DATA_ORDER_DESCRIPTION => 'aaa',
            DataSet::GENERAL_DATA_ORDER_DATA_ORDER_ID => 'olo',
            DataSet::GENERAL_DATA_ORDER_DATA_MERCHANT_TRANSACTION_ID => 'bbb',
            DataSet::GENERAL_DATA_ORDER_DATA_MERCHANT_USER_ID => 'ccc',
            DataSet::GENERAL_DATA_ORDER_DATA_ORDER_META => ['foo'],
            DataSet::GENERAL_DATA_ORDER_DATA_RECIPIENT_NAME => 'qqq',
        ];

        $order = new Order();
        $raw = $order->setDescription('aaa')
            ->setID('olo')
            ->setMerchantTransactionID('bbb')
            ->setMerchantUserID('ccc')
            ->setMeta(['foo'])
            ->setRecipientName('qqq')
            ->getRaw();

        $this->assertEquals($expected, $raw);
    }
}
