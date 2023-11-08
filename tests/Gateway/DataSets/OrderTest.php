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
    public function testSuccess(): void
    {
        $expected = [
            DataSet::GENERAL_DATA_ORDER_DATA_ORDER_DESCRIPTION => 'aaa',
            DataSet::GENERAL_DATA_ORDER_DATA_ORDER_ID => 'olo',
            DataSet::GENERAL_DATA_ORDER_DATA_MERCHANT_TRANSACTION_ID => 'bbb',
            DataSet::GENERAL_DATA_ORDER_DATA_MERCHANT_USER_ID => 'ccc',
            DataSet::GENERAL_DATA_ORDER_DATA_ORDER_META => ['foo'],
            DataSet::GENERAL_DATA_ORDER_DATA_RECIPIENT_NAME => 'qqq',
            DataSet::GENERAL_DATA_ORDER_DATA_MERCHANT_REFERRING_NAME => 'www',
            DataSet::GENERAL_DATA_ORDER_DATA_CUSTOM_3D_RETURN_URL => 'hhh',
            DataSet::GENERAL_DATA_ORDER_DATA_CUSTOM_RETURN_URL => 'jjj',
            DataSet::GENERAL_DATA_ORDER_DATA_RECURRING_EXPIRY => 'kkk',
            DataSet::GENERAL_DATA_ORDER_DATA_RECURRING_FREQUENCY => 'lll',
            DataSet::GENERAL_DATA_ORDER_DATA_MITS_EXPECTED => true,
            DataSet::GENERAL_DATA_ORDER_DATA_VARIABLE_AMOUNT_RECURRING => true,
        ];

        $order = new Order();
        $raw = $order->setDescription('aaa')
            ->setID('olo')
            ->setMerchantTransactionID('bbb')
            ->setMerchantUserID('ccc')
            ->setMeta(['foo'])
            ->setRecipientName('qqq')
            ->setMerchantReferringName('www')
            ->setCustom3dReturnUrl('hhh')
            ->setCustomReturnUrl('jjj')
            ->setRecurringExpiry('kkk')
            ->setRecurringFrequency('lll')
            ->setMitsExpected()
            ->setVariableAmountRecurring()
            ->getRaw();

        $this->assertEquals($expected, $raw);
    }
}
