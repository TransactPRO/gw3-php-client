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
    public function testSuccess(): void
    {
        $expected = [
            DataSet::PAYMENT_METHOD_DATA_PAN => '123123',
            DataSet::PAYMENT_METHOD_DATA_CVV => '123',
            DataSet::PAYMENT_METHOD_DATA_EXPIRE => '12/21',
            DataSet::PAYMENT_METHOD_DATA_CARDHOLDER_NAME => 'John Doe',
            DataSet::PAYMENT_METHOD_DATA_TOKEN => 'dummy-token',
            DataSet::PAYMENT_METHOD_DATA_EXTERNAL_MPI_PROTOCOL => '2.2.0',
            DataSet::PAYMENT_METHOD_DATA_EXTERNAL_MPI_DS_TRANS_ID => '26221368-1c3d-4f3c-ba34-2efb76644c32',
            DataSet::PAYMENT_METHOD_DATA_EXTERNAL_MPI_XID => 'b+f8duAy8jNTQ0DB4U3mSmPyp8s=',
            DataSet::PAYMENT_METHOD_DATA_EXTERNAL_MPI_CAVV => 'kBMI/uGZvlKCygBkcQIlLJeBTPLG',
            DataSet::PAYMENT_METHOD_DATA_EXTERNAL_MPI_TRANS_STATUS => 'Y',
            DataSet::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_CRYPTOGRAM => 'qqq',
            DataSet::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_ECI => '07',
            DataSet::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_TRANS_STATUS => 'Y',
            DataSet::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_DS_TRANS_ID => '123-qwe-asd',
            DataSet::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_ACS_TRANS_ID => 'zxc-asd-qwe',
            DataSet::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_AUTHENTICATED => true,
        ];

        $paymentMethod = new PaymentMethod();
        $raw = $paymentMethod
            ->setPAN('123123')
            ->setCVV('123')
            ->setExpire('12/21')
            ->setCardHolderName('John Doe')
            ->setToken('dummy-token')
            ->setExternalMpiProtocolVersion('2.2.0')
            ->setExternalMpiDsTransID('26221368-1c3d-4f3c-ba34-2efb76644c32')
            ->setExternalMpiXID('b+f8duAy8jNTQ0DB4U3mSmPyp8s=')
            ->setExternalMpiCAVV('kBMI/uGZvlKCygBkcQIlLJeBTPLG')
            ->setExternalMpiTransStatus('Y')
            ->setExternalTokenCryptogram('qqq')
            ->setExternalTokenECI('07')
            ->setExternalTokenTransStatus('Y')
            ->setExternalTokenDsTransId('123-qwe-asd')
            ->setExternalTokenAcsTransId('zxc-asd-qwe')
            ->setExternalTokenCardHolderAuthenticated(true)
            ->getRaw();

        $this->assertEquals($expected, $raw);
    }
}
