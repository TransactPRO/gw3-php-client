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
 * Class Order.
 *
 * Class Order has all methods to fill `general-data.order-data` block of the request.
 */
class Order extends DataSet implements DataSetInterface
{
    /**
     * @param  string $merchantTransactionID
     * @return Order
     */
    public function setMerchantTransactionID(string $merchantTransactionID): self
    {
        $this->data[self::GENERAL_DATA_ORDER_DATA_MERCHANT_TRANSACTION_ID] = $merchantTransactionID;

        return $this;
    }

    /**
     * @param  string $merchantUserID
     * @return Order
     */
    public function setMerchantUserID(string $merchantUserID): self
    {
        $this->data[self::GENERAL_DATA_ORDER_DATA_MERCHANT_USER_ID] = $merchantUserID;

        return $this;
    }

    /**
     * @param  string $id
     * @return Order
     */
    public function setID(string $id): self
    {
        $this->data[self::GENERAL_DATA_ORDER_DATA_ORDER_ID] = $id;

        return $this;
    }

    /**
     * @param  string $description
     * @return Order
     */
    public function setDescription(string $description): self
    {
        $this->data[self::GENERAL_DATA_ORDER_DATA_ORDER_DESCRIPTION] = $description;

        return $this;
    }

    /**
     * @param  array $meta
     * @return Order
     */
    public function setMeta(array $meta): self
    {
        $this->data[self::GENERAL_DATA_ORDER_DATA_ORDER_META] = $meta;

        return $this;
    }
}