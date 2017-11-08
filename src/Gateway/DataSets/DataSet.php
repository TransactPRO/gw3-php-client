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

abstract class DataSet
{
    // auth data
    const AUTH_DATA_ACCOUNT_ID = 'auth-data.account-id';
    const AUTH_DATA_SECRET_KEY = 'auth-data.secret-key';
    const AUTH_DATA_SESSION_ID = 'auth-data.session-id';

    // command data
    const COMMAND_DATA_GATEWAY_TRANSACTION_ID = 'data.command-data.gateway-transaction-id';
    const COMMAND_DATA_GATEWAY_TRANSACTION_IDS = 'data.command-data.gateway-transaction-ids';
    const COMMAND_DATA_MERCHANT_TRANSACTION_IDS = 'data.command-data.merchant-transaction-ids';
    const COMMAND_DATA_FORM_ID = 'data.command-data.form-id';
    const COMMAND_DATA_TERMINAL_MID = 'data.command-data.terminal-mid';

    // customer data
    const GENERAL_DATA_CUSTOMER_DATA_EMAIL = 'data.general-data.customer-data.email';
    const GENERAL_DATA_CUSTOMER_DATA_PHONE = 'data.general-data.customer-data.phone';
    const GENERAL_DATA_CUSTOMER_DATA_BIRTH_DATE = 'data.general-data.customer-data.birth-date';
    const GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_COUNTRY = 'data.general-data.customer-data.billing-address.country';
    const GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_STATE = 'data.general-data.customer-data.billing-address.state';
    const GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_CITY = 'data.general-data.customer-data.billing-address.city';
    const GENERAL_DATA_CUSTOMER_DATA_BILlING_ADDRESS_STREET = 'data.general-data.customer-data.billing-address.street';
    const GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_HOUSE = 'data.general-data.customer-data.billing-address.house';
    const GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_FLAT = 'data.general-data.customer-data.billing-address.flat';
    const GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_ZIP = 'data.general-data.customer-data.billing-address.zip';
    const GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_COUNTRY = 'data.general-data.customer-data.shipping-address.country';
    const GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_STATE = 'data.general-data.customer-data.shipping-address.state';
    const GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_CITY = 'data.general-data.customer-data.shipping-address.city';
    const GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_STREET = 'data.general-data.customer-data.shipping-address.street';
    const GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_HOUSE = 'data.general-data.customer-data.shipping-address.house';
    const GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_FLAT = 'data.general-data.customer-data.shipping-address.flat';
    const GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_ZIP = 'data.general-data.customer-data.shipping-address.zip';

    // order data
    const GENERAL_DATA_ORDER_DATA_MERCHANT_TRANSACTION_ID = 'data.general-data.order-data.merchant-transaction-id';
    const GENERAL_DATA_ORDER_DATA_MERCHANT_USER_ID = 'data.general-data.order-data.merchant-user-id';
    const GENERAL_DATA_ORDER_DATA_ORDER_ID = 'data.general-data.order-data.order-id';
    const GENERAL_DATA_ORDER_DATA_ORDER_DESCRIPTION = 'data.general-data.order-data.order-description';
    const GENERAL_DATA_ORDER_DATA_ORDER_META = 'data.general-data.order-data.order-meta';
    const GENERAL_DATA_ORDER_DATA_MERCHANT_SIDE_URL = 'data.general-data.order-data.merchant-side-url';
    const GENERAL_DATA_ORDER_DATA_RECIPIENT_NAME = 'data.general-data.order-data.recipient-name';

    // payment data
    const PAYMENT_METHOD_DATA_PAN = 'data.payment-method-data.pan';
    const PAYMENT_METHOD_DATA_EXPIRE = 'data.payment-method-data.exp-mm-yy';
    const PAYMENT_METHOD_DATA_CVV = 'data.payment-method-data.cvv';
    const PAYMENT_METHOD_DATA_CARDHOLDER_NAME = 'data.payment-method-data.cardholder-name';
    const PAYMENT_METHOD_DATA_EXTERNAL_MPI_DATA = 'data.payment-method-data.external-mpi-data';

    // money data
    const MONEY_DATA_AMOUNT = 'data.money-data.amount';
    const MONEY_DATA_CURRENCY = 'data.money-data.currency';

    // system
    const SYSTEM_USER_IP = 'data.system.user-ip';
    const SYSTEM_X_FORWARDED_FOR = 'data.system.x-forwarded-for';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return array
     */
    public function getRaw()
    {
        return $this->data;
    }
}
