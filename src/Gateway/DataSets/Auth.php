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
     * @param  int  $accountID
     * @return Auth
     */
    public function setAccountID(int $accountID): self
    {
        $this->data[self::AUTH_DATA_ACCOUNT_ID] = $accountID;

        return $this;
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
}
