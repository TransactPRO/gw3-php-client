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
 * Class FilterData.
 * Class FilterData has all methods to fill `filter-data` block of the request.
 */
class FilterData extends DataSet implements DataSetInterface
{
    /**
     * @param int $dtCreatedFromTimestamp
     *
     * @return FilterData
     */
    public function setDtCreatedFrom(int $dtCreatedFromTimestamp): self
    {
        $this->data[self::FILTER_DATA_DT_CREATED_FROM] = $dtCreatedFromTimestamp;

        return $this;
    }

    /**
     * @param int $dtCreatedToTimestamp
     *
     * @return FilterData
     */
    public function setDtCreatedTo(int $dtCreatedToTimestamp): self
    {
        $this->data[self::FILTER_DATA_DT_CREATED_TO] = $dtCreatedToTimestamp;

        return $this;
    }

    /**
     * @param int $dtFinishedFromTimestamp
     *
     * @return FilterData
     */
    public function setDtFinishedFrom(int $dtFinishedFromTimestamp): self
    {
        $this->data[self::FILTER_DATA_DT_FINISHED_FROM] = $dtFinishedFromTimestamp;

        return $this;
    }

    /**
     * @param int $dtFinishedToTimestamp
     *
     * @return FilterData
     */
    public function setDtFinishedTo(int $dtFinishedToTimestamp): self
    {
        $this->data[self::FILTER_DATA_DT_FINISHED_TO] = $dtFinishedToTimestamp;

        return $this;
    }
}
