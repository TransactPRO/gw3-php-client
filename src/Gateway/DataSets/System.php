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
 * Class System.
 *
 * Class System has all methods to fill `auth-data` block of the request.
 */
class System extends DataSet implements DataSetInterface
{
    /**
     * @param  string $userIP
     * @return System
     */
    public function setUserIP(string $userIP): self
    {
        $this->data[self::SYSTEM_USER_IP] = $userIP;

        return $this;
    }

    /**
     * @param  string $xForwardedFor
     * @return System
     */
    public function setXForwardedFor(string $xForwardedFor): self
    {
        $this->data[self::SYSTEM_X_FORWARDED_FOR] = $xForwardedFor;

        return $this;
    }
}
