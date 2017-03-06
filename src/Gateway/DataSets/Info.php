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
 * Class Info.
 *
 * Class Info has all methods to fill `command-data` block of the info requests.
 */
class Info extends DataSet implements DataSetInterface
{
    /**
     * @param  array $gatewayTransactionIDs
     * @return Info
     */
    public function setGatewayTransactionIDs(array $gatewayTransactionIDs): self
    {
        $this->data[self::COMMAND_DATA_GATEWAY_TRANSACTION_IDS] = $gatewayTransactionIDs;

        return $this;
    }

    /**
     * @param  array $merchantTransactionIDs
     * @return Info
     */
    public function setMerchantTransactionIDs(array $merchantTransactionIDs): self
    {
        $this->data[self::COMMAND_DATA_MERCHANT_TRANSACTION_IDS] = $merchantTransactionIDs;

        return $this;
    }
}
