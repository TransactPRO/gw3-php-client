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
    const AUTH_DATA_ACCOUNT_GUID = 'auth-data.account-guid';
    const AUTH_DATA_MERCHANT_GUID = 'auth-data.merchant-guid';
    const AUTH_DATA_SECRET_KEY = 'auth-data.secret-key';
    const AUTH_DATA_SESSION_ID = 'auth-data.session-id';

    // command data
    const COMMAND_DATA_GATEWAY_TRANSACTION_ID = 'data.command-data.gateway-transaction-id';
    const COMMAND_DATA_GATEWAY_TRANSACTION_IDS = 'data.command-data.gateway-transaction-ids';
    const COMMAND_DATA_MERCHANT_TRANSACTION_IDS = 'data.command-data.merchant-transaction-ids';
    const COMMAND_DATA_FORM_ID = 'data.command-data.form-id';
    const COMMAND_DATA_TERMINAL_MID = 'data.command-data.terminal-mid';
    const COMMAND_DATA_CARD_VERIFICATION = 'data.command-data.card-verification';
    const COMMAND_DATA_PAYMENT_METHOD_DATA_SOURCE = 'data.command-data.payment-method-data-source';
    const COMMAND_DATA_PAYMENT_METHOD_DATA_TOKEN = 'data.command-data.payment-method-data-token';

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
    const GENERAL_DATA_ORDER_DATA_MERCHANT_REFERRING_NAME = 'data.general-data.order-data.merchant-referring-name';
    const GENERAL_DATA_ORDER_DATA_CUSTOM_3D_RETURN_URL = 'data.general-data.order-data.custom-3d-return-url';
    const GENERAL_DATA_ORDER_DATA_CUSTOM_RETURN_URL = 'data.general-data.order-data.custom-return-url';
    const GENERAL_DATA_ORDER_DATA_RECURRING_EXPIRY = 'data.general-data.order-data.recurring-expiry';
    const GENERAL_DATA_ORDER_DATA_RECURRING_FREQUENCY = 'data.general-data.order-data.recurring-frequency';
    const GENERAL_DATA_ORDER_DATA_MITS_EXPECTED = 'data.general-data.order-data.mits-expected';
    const GENERAL_DATA_ORDER_DATA_VARIABLE_AMOUNT_RECURRING = 'data.general-data.order-data.variable-amount-recurring';

    // payment data
    const PAYMENT_METHOD_DATA_PAN = 'data.payment-method-data.pan';
    const PAYMENT_METHOD_DATA_EXPIRE = 'data.payment-method-data.exp-mm-yy';
    const PAYMENT_METHOD_DATA_CVV = 'data.payment-method-data.cvv';
    const PAYMENT_METHOD_DATA_CARDHOLDER_NAME = 'data.payment-method-data.cardholder-name';
    const PAYMENT_METHOD_DATA_EXTERNAL_MPI_DATA = 'data.payment-method-data.external-mpi-data';
    const PAYMENT_METHOD_DATA_EXTERNAL_MPI_PROTOCOL = 'data.payment-method-data.external-mpi-data.protocolVersion';
    const PAYMENT_METHOD_DATA_EXTERNAL_MPI_DS_TRANS_ID = 'data.payment-method-data.external-mpi-data.dsTransID';
    const PAYMENT_METHOD_DATA_EXTERNAL_MPI_XID = 'data.payment-method-data.external-mpi-data.xid';
    const PAYMENT_METHOD_DATA_EXTERNAL_MPI_CAVV = 'data.payment-method-data.external-mpi-data.cavv';
    const PAYMENT_METHOD_DATA_EXTERNAL_MPI_TRANS_STATUS = 'data.payment-method-data.external-mpi-data.transStatus';

    // money data
    const MONEY_DATA_AMOUNT = 'data.money-data.amount';
    const MONEY_DATA_CURRENCY = 'data.money-data.currency';

    // system
    const SYSTEM_USER_IP = 'data.system.user-ip';
    const SYSTEM_X_FORWARDED_FOR = 'data.system.x-forwarded-for';
    const SYSTEM_BROWSER_ACCEPT_HEADER = 'data.system.browser-accept-header';
    const SYSTEM_BROWSER_JAVA_ENABLED = 'data.system.browser-java-enabled';
    const SYSTEM_BROWSER_JAVASCRIPT_ENABLED = 'data.system.browser-javascript-enabled';
    const SYSTEM_BROWSER_LANGUAGE = 'data.system.browser-language';
    const SYSTEM_BROWSER_COLOR_DEPTH = 'data.system.browser-color-depth';
    const SYSTEM_BROWSER_SCREEN_HEIGHT = 'data.system.browser-screen-height';
    const SYSTEM_BROWSER_SCREEN_WIDTH = 'data.system.browser-screen-width';
    const SYSTEM_BROWSER_TZ = 'data.system.browser-tz';
    const SYSTEM_BROWSER_USER_AGENT = 'data.system.browser-user-agent';

    // data
    const DATA_TERMINAL_MID = 'data.terminal-mid';
    const DATA_CURRENCY = 'data.currency';
    const DATA_PAN = 'data.pan';
    const DATA_GATEWAY_TRANSACTION_ID = 'data.gateway-transaction-id';

    // filter data
    const FILTER_DATA_DT_CREATED_FROM = 'filter-data.dt-created-from';
    const FILTER_DATA_DT_CREATED_TO = 'filter-data.dt-created-to';
    const FILTER_DATA_DT_FINISHED_FROM = 'filter-data.dt-finished-from';
    const FILTER_DATA_DT_FINISHED_TO = 'filter-data.dt-finished-to';

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
