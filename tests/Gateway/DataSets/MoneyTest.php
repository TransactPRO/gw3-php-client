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

use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testSuccess()
    {
        $expected = [
            DataSet::MONEY_DATA_AMOUNT => 100,
            DataSet::MONEY_DATA_CURRENCY => 'EUR',
        ];

        $money = new Money();
        $raw = $money->setAmount(100)
            ->setCurrency('EUR')
            ->getRaw();

        $this->assertEquals($expected, $raw);
    }
}
