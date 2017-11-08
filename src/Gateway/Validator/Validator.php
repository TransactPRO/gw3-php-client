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

        // payment data
        DataSet::PAYMENT_METHOD_DATA_PAN => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXPIRE => 'string',
        DataSet::PAYMENT_METHOD_DATA_CVV => 'string',
        DataSet::PAYMENT_METHOD_DATA_CARDHOLDER_NAME => 'string',
        DataSet::PAYMENT_METHOD_DATA_EXTERNAL_MPI_DATA => 'string',

        // money data
        DataSet::MONEY_DATA_AMOUNT => 'integer',
        DataSet::MONEY_DATA_CURRENCY => 'string',

        // system
        DataSet::SYSTEM_USER_IP => 'string',
        DataSet::SYSTEM_X_FORWARDED_FOR => 'string',
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

            if (!isset($data[$key])) {
                $errors[] = "No value by \"$key\" is found.";
                continue;
            }
            $value = $data[$key];

            $realType = gettype($value);
            $expectedType = $this->fieldTypes[$key];

            if ($realType !== $expectedType) {
                $errors[] = "Type of \"$value\" should be \"$expectedType\", but is \"$realType\"";
                continue;
            }
        }

        if (count($errors) > 0) {
            throw new ValidatorException(implode("; ", $errors));
        }

        return true;
    }
}
