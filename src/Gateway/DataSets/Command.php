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

use TransactPro\Gateway\Interfaces\DataSetInterface;

/**
 * Class Command.
 *
 * Class Command has all methods to fill `command-data` block of the request.
 */
class Command extends DataSet implements DataSetInterface
{
    const CARD_VERIFICATION_MODE_INIT = 1;
    const CARD_VERIFICATION_MODE_VERIFY = 2;

    const DATA_SOURCE_CARDHOLDER = 0;
    const DATA_SOURCE_SAVE_TO_GATEWAY = 1;
    const DATA_SOURCE_USE_GATEWAY_SAVED_CARDHOLDER_INITIATED = 2;
    const DATA_SOURCE_SAVING_BY_MERCHANT = 3;
    const DATA_SOURCE_USE_MERCHANT_SAVED_CARDHOLDER_INITIATED = 4;
    const DATA_SOURCE_USE_GATEWAY_SAVED_MERCHANT_INITIATED = 5;
    const DATA_SOURCE_USE_MERCHANT_SAVED_MERCHANT_INITIATED = 6;

    /**
     * @param  string  $gatewayTransactionID
     * @return Command
     */
    public function setGatewayTransactionID(string $gatewayTransactionID): self
    {
        $this->data[self::COMMAND_DATA_GATEWAY_TRANSACTION_ID] = $gatewayTransactionID;

        return $this;
    }

    /**
     * @param  string  $formID
     * @return Command
     */
    public function setFormID(string $formID): self
    {
        $this->data[self::COMMAND_DATA_FORM_ID] = $formID;

        return $this;
    }

    /**
     * @param  string  $terminalMID
     * @return Command
     */
    public function setTerminalMID(string $terminalMID): self
    {
        $this->data[self::COMMAND_DATA_TERMINAL_MID] = $terminalMID;

        return $this;
    }

    /**
     * @param  int     $cardVerificationMode
     * @return Command
     */
    public function setCardVerificationMode(int $cardVerificationMode): self
    {
        $this->data[self::COMMAND_DATA_CARD_VERIFICATION] = $cardVerificationMode;

        return $this;
    }

    /**
     * @param  int     $paymentMethodDataSource
     * @return Command
     */
    public function setPaymentMethodDataSource(int $paymentMethodDataSource): self
    {
        $this->data[self::COMMAND_DATA_PAYMENT_METHOD_DATA_SOURCE] = $paymentMethodDataSource;

        return $this;
    }

    /**
     * @param  string  $paymentMethodDataToken
     * @return Command
     */
    public function setPaymentMethodDataToken(string $paymentMethodDataToken): self
    {
        $this->data[ self::COMMAND_DATA_PAYMENT_METHOD_DATA_TOKEN ] = $paymentMethodDataToken;

        return $this;
    }
}
