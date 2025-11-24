<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Validator;

use TransactPro\Gateway\DataSets\Command;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\Exceptions\ValidatorException;

/**
 * Class Validator.
 *
 * Validator class is responsible to check for mandatory data,
 * for specific operation.
 */
class Validator
{
    /**
     * All available fields type.
     *
     * Structured as `$name => $type`.
     *
     * @var array
     */
    private $fieldTypes = [
        // command data
        DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_ID => 'string',
        DataSet::COMMAND_DATA_FORM_ID => 'string',
        DataSet::COMMAND_DATA_TERMINAL_MID => 'string',
        DataSet::COMMAND_DATA_CARD_VERIFICATION => 'integer',
        DataSet::COMMAND_DATA_PAYMENT_METHOD_DATA_SOURCE => 'integer',
        DataSet::COMMAND_DATA_PAYMENT_METHOD_DATA_TOKEN => 'string',
        DataSet::COMMAND_DATA_PAYMENT_METHOD_TYPE => 'string',

        // general data
        DataSet::GENERAL_DATA_CUSTOMER_DATA_EMAIL => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_PHONE => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_BIRTH_DATE => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_COUNTRY => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_STATE => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_CITY => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_BILlING_ADDRESS_STREET => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_HOUSE => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_FLAT => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_BILLING_ADDRESS_ZIP => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_COUNTRY => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_STATE => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_CITY => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_STREET => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_HOUSE => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_FLAT => 'string',
        DataSet::GENERAL_DATA_CUSTOMER_DATA_SHIPPING_ADDRESS_ZIP => 'string',

        // merchant order data
        DataSet::GENERAL_DATA_ORDER_DATA_MERCHANT_TRANSACTION_ID => 'string',
        DataSet::GENERAL_DATA_ORDER_DATA_MERCHANT_USER_ID => 'string',
        DataSet::GENERAL_DATA_ORDER_DATA_ORDER_ID => 'string',
        DataSet::GENERAL_DATA_ORDER_DATA_ORDER_DESCRIPTION => 'string',
        DataSet::GENERAL_DATA_ORDER_DATA_ORDER_META => 'array',
        DataSet::GENERAL_DATA_ORDER_DATA_MERCHANT_SIDE_URL => 'string',
        DataSet::GENERAL_DATA_ORDER_DATA_RECIPIENT_NAME => 'string',
        DataSet::GENERAL_DATA_ORDER_DATA_MERCHANT_REFERRING_NAME => 'string',
        DataSet::GENERAL_DATA_ORDER_DATA_CUSTOM_3D_RETURN_URL => 'string',
        DataSet::GENERAL_DATA_ORDER_DATA_CUSTOM_RETURN_URL => 'string',
        DataSet::GENERAL_DATA_ORDER_DATA_RECURRING_EXPIRY => 'string',
        DataSet::GENERAL_DATA_ORDER_DATA_RECURRING_FREQUENCY => 'string',
        DataSet::GENERAL_DATA_ORDER_DATA_MITS_EXPECTED => 'boolean',
        DataSet::GENERAL_DATA_ORDER_DATA_VARIABLE_AMOUNT_RECURRING => 'boolean',

        // payment data
        DataSet::PAYMENT_METHOD_DATA_PAN => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXPIRE => 'string',
        DataSet::PAYMENT_METHOD_DATA_CVV => 'string',
        DataSet::PAYMENT_METHOD_DATA_CARDHOLDER_NAME => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXTERNAL_MPI_PROTOCOL => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXTERNAL_MPI_DS_TRANS_ID => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXTERNAL_MPI_XID => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXTERNAL_MPI_CAVV => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXTERNAL_MPI_TRANS_STATUS => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_CRYPTOGRAM => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_ECI => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_TRANS_STATUS => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_DS_TRANS_ID => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_ACS_TRANS_ID => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_AUTHENTICATED => 'boolean',

        // money data
        DataSet::MONEY_DATA_AMOUNT => 'integer',
        DataSet::MONEY_DATA_CURRENCY => 'string',

        // system
        DataSet::SYSTEM_USER_IP => 'string',
        DataSet::SYSTEM_X_FORWARDED_FOR => 'string',
        DataSet::SYSTEM_BROWSER_ACCEPT_HEADER => 'string',
        DataSet::SYSTEM_BROWSER_JAVA_ENABLED => 'boolean',
        DataSet::SYSTEM_BROWSER_JAVASCRIPT_ENABLED => 'boolean',
        DataSet::SYSTEM_BROWSER_LANGUAGE => 'string',
        DataSet::SYSTEM_BROWSER_COLOR_DEPTH => 'string',
        DataSet::SYSTEM_BROWSER_SCREEN_HEIGHT => 'string',
        DataSet::SYSTEM_BROWSER_SCREEN_WIDTH => 'string',
        DataSet::SYSTEM_BROWSER_TZ => 'string',
        DataSet::SYSTEM_BROWSER_USER_AGENT => 'string',

        // top level data
        DataSet::DATA_TERMINAL_MID => 'string',
        DataSet::DATA_CURRENCY => 'string',
        DataSet::DATA_PAN => 'string',
        DataSet::DATA_GATEWAY_TRANSACTION_ID => 'string',

        // filter data
        DataSet::FILTER_DATA_DT_CREATED_FROM => 'integer',
        DataSet::FILTER_DATA_DT_CREATED_TO => 'integer',
        DataSet::FILTER_DATA_DT_FINISHED_FROM => 'integer',
        DataSet::FILTER_DATA_DT_FINISHED_TO => 'integer',
    ];

    /**
     * Validate provided data.
     *
     * Will validate $data against $mandatory keys.
     * If some key will not be present, or will be in incorrect format -
     * it will throw ValidatorException.
     *
     * On success it will return `true`.
     *
     * @param  array              $mandatory Array of mandatory keys
     * @param  array              $data      Original data provided
     * @throws ValidatorException
     * @return bool
     */
    public function validate(array $mandatory, array $data): bool
    {
        $errors = [];

        // loop over mandatory keys to check their presence and correct type
        for ($i = 0, $c = count($mandatory); $i < $c; $i++) {
            $key = $mandatory[$i];

            if (!$this->validateData($data, $key)) {
                $errors[] = "No value by \"$key\" is found.";
                continue;
            }

            if (isset($data[$key])) {
                $value = $data[$key];
                $realType = gettype($value);
                $expectedType = $this->fieldTypes[$key];

                if ($realType !== $expectedType) {
                    $errors[] = "Type of \"$value\" should be \"$expectedType\", but is \"$realType\"";
                    continue;
                }
            }
        }

        if (count($errors) > 0) {
            throw new ValidatorException(implode("; ", $errors));
        }

        return true;
    }

    private function validateData(array $data, string $key): bool
    {
        if (isset($data[$key])) {
            return true;
        }

        $paymentMethodType = $data[DataSet::COMMAND_DATA_PAYMENT_METHOD_TYPE] ?? Command::PAYMENT_METHOD_TYPE_CARD;
        if ($paymentMethodType !== Command::PAYMENT_METHOD_TYPE_CARD) {
            static $cardDataKeys = [
                DataSet::PAYMENT_METHOD_DATA_PAN,
                DataSet::PAYMENT_METHOD_DATA_EXPIRE,
                DataSet::PAYMENT_METHOD_DATA_CVV,
            ];

            $tokenPassed = isset($data[DataSet::PAYMENT_METHOD_DATA_TOKEN]);
            if ($tokenPassed) {
                // encrypted token is passed intead of plain card data
                return in_array($key, $cardDataKeys);
            } else {
                // decrypted token doesn't contain CVV
                return $key === DataSet::PAYMENT_METHOD_DATA_CVV;
            }
        }

        return false;
    }
}
