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

    /**
     * @param string $merchantSideURL
     *
     * @return Order
     */
    public function setMerchantSideUrl(string $merchantSideURL): self
    {
        $this->data[self::GENERAL_DATA_ORDER_DATA_MERCHANT_SIDE_URL] = $merchantSideURL;

        return $this;
    }

    /**
     * @param string $recipientName
     *
     * @return Order
     */
    public function setRecipientName(string $recipientName): self
    {
        $this->data[self::GENERAL_DATA_ORDER_DATA_RECIPIENT_NAME] = $recipientName;

        return $this;
    }

    /**
     * @param  string $merchantReferringName
     * @return Order
     */
    public function setMerchantReferringName(string $merchantReferringName): self
    {
        $this->data[self::GENERAL_DATA_ORDER_DATA_MERCHANT_REFERRING_NAME] = $merchantReferringName;

        return $this;
    }

    /**
     * @param string $custom3dReturnUrl
     *
     * @return Order
     */
    public function setCustom3dReturnUrl(string $custom3dReturnUrl): self
    {
        $this->data[ self::GENERAL_DATA_ORDER_DATA_CUSTOM_3D_RETURN_URL ] = $custom3dReturnUrl;

        return $this;
    }

    /**
     * @param string $customReturnUrl
     *
     * @return Order
     */
    public function setCustomReturnUrl(string $customReturnUrl): self
    {
        $this->data[ self::GENERAL_DATA_ORDER_DATA_CUSTOM_RETURN_URL ] = $customReturnUrl;

        return $this;
    }

    /**
     * @param string $recurringExpiry
     *
     * @return Order
     */
    public function setRecurringExpiry(string $recurringExpiry): self
    {
        $this->data[ self::GENERAL_DATA_ORDER_DATA_RECURRING_EXPIRY ] = $recurringExpiry;

        return $this;
    }

    /**
     * @param string $recurringFrequency
     *
     * @return Order
     */
    public function setRecurringFrequency(string $recurringFrequency): self
    {
        $this->data[ self::GENERAL_DATA_ORDER_DATA_RECURRING_FREQUENCY ] = $recurringFrequency;

        return $this;
    }

    /**
     * @param bool $value (default: true)
     *
     * @return Order
     */
    public function setMitsExpected(bool $value = true): self
    {
        $this->data[ self::GENERAL_DATA_ORDER_DATA_MITS_EXPECTED ] = $value;

        return $this;
    }

    /**
     * @param bool $value (default: true)
     *
     * @return Order
     */
    public function setVariableAmountRecurring(bool $value = true): self
    {
        $this->data[ self::GENERAL_DATA_ORDER_DATA_VARIABLE_AMOUNT_RECURRING ] = $value;

        return $this;
    }
}
