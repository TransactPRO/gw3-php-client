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
 * Class Money.
 *
 * Class Money has all methods to fill `money-data` block of the request.
 */
class Money extends DataSet implements DataSetInterface
{
    /**
     * @param  int   $amount
     * @return Money
     */
    public function setAmount(int $amount): self
    {
        $this->data[self::MONEY_DATA_AMOUNT] = $amount;

        return $this;
    }

    /**
     * @param  string $currency
     * @return Money
     */
    public function setCurrency(string $currency): self
    {
        $this->data[self::MONEY_DATA_CURRENCY] = $currency;

        return $this;
    }
}
