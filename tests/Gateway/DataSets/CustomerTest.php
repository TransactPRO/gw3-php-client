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

class CustomerTest extends TestCase
{
    public function testSuccess()
    {
        $expected = [
            DataSet::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_CITY => 'a',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_COUNTRY => 'b',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_FLAT => 'c',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_HOUSE => 'd',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_STATE => 'e',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_BILlING_ADDRESS_STREET => 'f',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_ZIP => 'g',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_EMAIL => 'test@example.com',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_CITY => 'a',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_COUNTRY => 'b',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_FLAT => 'c',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_HOUSE => 'd',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_STATE => 'e',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_STREET => 'f',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_ZIP => 'g',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_PHONE => '123456789',
            DataSet::GENERAL_DATA_CUSTOMER_DATA_BIRTH_DATE => '01021900',
        ];

        $customer = new Customer();
        $raw = $customer->setBillingAddressCity('a')
            ->setBillingAddressCountry('b')
            ->setBillingAddressFlat('c')
            ->setBillingAddressHouse('d')
            ->setBillingAddressState('e')
            ->setBillingAddressStreet('f')
            ->setBillingAddressZIP('g')
            ->setEmail('test@example.com')
            ->setShippingAddressCity('a')
            ->setShippingAddressCountry('b')
            ->setShippingAddressFlat('c')
            ->setShippingAddressHouse('d')
            ->setShippingAddressState('e')
            ->setShippingAddressStreet('f')
            ->setShippingAddressZIP('g')
            ->setPhone('123456789')
            ->setBirthDate('01021900')
            ->getRaw();

        $this->assertEquals($expected, $raw);
    }
}
