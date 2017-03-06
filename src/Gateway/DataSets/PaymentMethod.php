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
 * Class PaymentMethod.
 *
 * Class PaymentMethod has all methods to fill `payment-method-data` block of the request.
 */
class PaymentMethod extends DataSet implements DataSetInterface
{
    /**
     * @param  string        $pan
     * @return PaymentMethod
     */
    public function setPAN(string $pan): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_PAN] = $pan;

        return $this;
    }

    /**
     * @param  string        $expire
     * @return PaymentMethod
     */
    public function setExpire(string $expire): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_EXPIRE] = $expire;

        return $this;
    }

    /**
     * @param  string        $cvv
     * @return PaymentMethod
     */
    public function setCVV(string $cvv): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_CVV] = $cvv;

        return $this;
    }

    /**
     * @param  string        $cardHolderName
     * @return PaymentMethod
     */
    public function setCardHolderName(string $cardHolderName): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_CARDHOLDER_NAME] = $cardHolderName;

        return $this;
    }
}
