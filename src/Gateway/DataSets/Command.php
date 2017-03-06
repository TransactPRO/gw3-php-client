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
}
