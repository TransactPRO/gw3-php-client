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

    /**
     * @param  string        $token
     * @return PaymentMethod
     */
    public function setToken(string $token): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_TOKEN] = $token;

        return $this;
    }

    /**
     * @param  string        $protocolVersion
     * @return PaymentMethod
     */
    public function setExternalMpiProtocolVersion(string $protocolVersion): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_EXTERNAL_MPI_PROTOCOL] = $protocolVersion;

        return $this;
    }

    /**
     * @param  string        $dsTransID
     * @return PaymentMethod
     */
    public function setExternalMpiDsTransID(string $dsTransID): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_EXTERNAL_MPI_DS_TRANS_ID] = $dsTransID;

        return $this;
    }

    /**
     * @param  string        $xid
     * @return PaymentMethod
     */
    public function setExternalMpiXID(string $xid): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_EXTERNAL_MPI_XID] = $xid;

        return $this;
    }

    /**
     * @param  string        $cavv
     * @return PaymentMethod
     */
    public function setExternalMpiCAVV(string $cavv): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_EXTERNAL_MPI_CAVV] = $cavv;

        return $this;
    }

    /**
     * @param  string        $transStatus
     * @return PaymentMethod
     */
    public function setExternalMpiTransStatus(string $transStatus): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_EXTERNAL_MPI_TRANS_STATUS] = $transStatus;

        return $this;
    }

    /**
     * @param  string        $cryptogram
     * @return PaymentMethod
     */
    public function setExternalTokenCryptogram(string $cryptogram): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_CRYPTOGRAM] = $cryptogram;

        return $this;
    }

    /**
     * @param  string        $eci
     * @return PaymentMethod
     */
    public function setExternalTokenECI(string $eci): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_ECI] = $eci;

        return $this;
    }

    /**
     * @param  string        $transStatus
     * @return PaymentMethod
     */
    public function setExternalTokenTransStatus(string $transStatus): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_TRANS_STATUS] = $transStatus;

        return $this;
    }

    /**
     * @param  string        $dsTransId
     * @return PaymentMethod
     */
    public function setExternalTokenDsTransId(string $dsTransId): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_DS_TRANS_ID] = $dsTransId;

        return $this;
    }

    /**
     * @param  string        $acsTransId
     * @return PaymentMethod
     */
    public function setExternalTokenAcsTransId(string $acsTransId): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_ACS_TRANS_ID] = $acsTransId;

        return $this;
    }

    /**
     * @param  bool          $value
     * @return PaymentMethod
     */
    public function setExternalTokenCardHolderAuthenticated(bool $value): self
    {
        $this->data[self::PAYMENT_METHOD_DATA_EXTERNAL_TOKEN_AUTHENTICATED] = $value;

        return $this;
    }
}
