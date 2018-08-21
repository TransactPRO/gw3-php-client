<?php declare(strict_types=1);

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
 * Class Verify3dEnrollment.
 * Class Verify3dEnrollment has all methods to fill data for 3D-Secure enrollment verification request.
 */
class Verify3dEnrollment extends DataSet implements DataSetInterface
{
    /**
     * @param  string $pan
     *
     * @return self
     */
    public function setPAN(string $pan): self
    {
        $this->data[ self::DATA_PAN ] = $pan;

        return $this;
    }

    /**
     * @param  string $terminalMID
     *
     * @return self
     */
    public function setTerminalMID(string $terminalMID): self
    {
        $this->data[ self::DATA_TERMINAL_MID ] = $terminalMID;

        return $this;
    }

    /**
     * @param  string $currency
     *
     * @return self
     */
    public function setCurrency(string $currency): self
    {
        $this->data[ self::DATA_CURRENCY ] = $currency;

        return $this;
    }
}
