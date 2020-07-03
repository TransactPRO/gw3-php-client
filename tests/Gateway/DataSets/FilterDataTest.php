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

class FilterDataTest extends TestCase
{
    public function testSuccess()
    {
        $expected = [
            DataSet::FILTER_DATA_DT_CREATED_FROM => 1,
            DataSet::FILTER_DATA_DT_CREATED_TO => 2,
            DataSet::FILTER_DATA_DT_FINISHED_FROM => 3,
            DataSet::FILTER_DATA_DT_FINISHED_TO => 4,
        ];

        $filterData = new FilterData();
        $raw = $filterData
            ->setDtCreatedFrom(1)
            ->setDtCreatedTo(2)
            ->setDtFinishedFrom(3)
            ->setDtFinishedTo(4)
            ->getRaw();

        $this->assertEquals($expected, $raw);
    }
}
