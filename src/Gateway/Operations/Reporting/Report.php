<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations\Reporting;

use TransactPro\Gateway\DataSets\FilterData;
use TransactPro\Gateway\Exceptions\ResponseException;
use TransactPro\Gateway\Interfaces\OperationInterface;
use TransactPro\Gateway\Interfaces\ResponseInterface;
use TransactPro\Gateway\Operations\Operation;
use TransactPro\Gateway\Responses\CsvResponse;
use TransactPro\Gateway\Validator\Validator;

/**
 * Class Report.
 *
 * This class describes dataset to perform Report request.
 * Refer to official documentation for more information about Report request.
 */
class Report extends Operation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    protected $path = '/report';

    /**
     * {@inheritdoc}
     */
    protected $method = 'POST';

    /**
     * @var FilterData
     */
    private $filterData;

    /**
     * Report constructor.
     *
     * @param Validator $validator
     * @param FilterData $filterData
     */
    public function __construct(Validator $validator, FilterData $filterData)
    {
        $this->validator = $validator;

        $this->filterData = $filterData;

        $this->dataSets = [$this->filterData];
    }

    /**
     * @return FilterData
     */
    public function filterData()
    {
        return $this->filterData;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return CsvResponse
     * @throws ResponseException
     */
    public function parseResponse(ResponseInterface $response): CsvResponse
    {
        return $response->parseCsv();
    }
}
