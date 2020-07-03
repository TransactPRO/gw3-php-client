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
 * Class Auth.
 *
 * Class Auth has all methods to fill `auth-data` block of the request.
 */
class Auth extends DataSet implements DataSetInterface
{
    /**
     * @return string|null
     */
    public function getObjectGUID()
    {
        return $this->getAccountGUID() ?? $this->getMerchantGUID();
    }

    /**
     * @return string|null
     */
    public function getMerchantGUID()
    {
        return $this->data[self::AUTH_DATA_MERCHANT_GUID] ?? null;
    }

    /**
     * @param string $merchantGUID
     *
     * @return Auth
     */
    public function setMerchantGUID(string $merchantGUID): self
    {
        $this->data[self::AUTH_DATA_MERCHANT_GUID] = $merchantGUID;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccountGUID()
    {
        return $this->data[self::AUTH_DATA_ACCOUNT_GUID] ?? null;
    }

    /**
     * @param string $accountGUID
     *
     * @return Auth
     */
    public function setAccountGUID(string $accountGUID): self
    {
        $this->data[self::AUTH_DATA_ACCOUNT_GUID] = $accountGUID;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSecretKey()
    {
        return $this->data[self::AUTH_DATA_SECRET_KEY] ?? null;
    }

    /**
     * @param  string $secretKey
     * @return Auth
     */
    public function setSecretKey(string $secretKey): self
    {
        $this->data[self::AUTH_DATA_SECRET_KEY] = $secretKey;

        return $this;
    }

    /**
     * @param  string $sessionID
     * @return Auth
     */
    public function setSessionID(string $sessionID): self
    {
        $this->data[self::AUTH_DATA_SESSION_ID] = $sessionID;

        return $this;
    }

    /**
     * @return array
     */
    public function getRaw()
    {
        $result = [];
        if (isset($this->data[self::AUTH_DATA_SESSION_ID])) {
            $result[self::AUTH_DATA_SESSION_ID] = $this->data[self::AUTH_DATA_SESSION_ID];
        }

        return $result;
    }
}
