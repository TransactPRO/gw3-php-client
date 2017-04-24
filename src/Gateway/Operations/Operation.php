<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations;

use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\Http\Request;
use TransactPro\Gateway\Interfaces\DataSetInterface;
use TransactPro\Gateway\Interfaces\OperationInterface;
use TransactPro\Gateway\Validator\Validator;

abstract class Operation implements OperationInterface
{
    /**
     * Path of the request. Should always start with "/".
     *
     * @var string
     */
    protected $path = '/';

    /**
     * HTTP method of the request (ex.: GET, POST, ...).
     *
     * @var string
     */
    protected $method = 'NONE';

    /**
     * List of mandatory fields that
     * should be present to perform successful request.
     *
     * @var array
     */
    protected $mandatoryFields = [];

    /**
     * Array of DataSets.
     *
     * @var array
     */
    protected $dataSets = [];

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * Array of merged data extracted from DataSets.
     *
     * @var array
     */
    protected $data = [];

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        $this->addSets(...$this->dataSets);

        $this->validator->validate($this->mandatoryFields, $this->data);

        return new Request($this->method, $this->path, $this->data);
    }

    /**
     * @param  DataSetInterface[] ...$dataSets
     * @return void
     */
    protected function addSets(DataSetInterface ...$dataSets)
    {
        foreach ($dataSets as $dataSet) {
            $this->data = array_merge($this->data, $dataSet->getRaw());
        }
    }

    /**
     * Prepares request for inside-form
     */
    public function insideForm()
    {
        // payment data should be ignored by library validation,
        // because on inside-form client will input this data
        $ignoreFields = [
            DataSet::PAYMENT_METHOD_DATA_PAN,
            DataSet::PAYMENT_METHOD_DATA_EXPIRE,
            DataSet::PAYMENT_METHOD_DATA_CVV,
            DataSet::PAYMENT_METHOD_DATA_CARDHOLDER_NAME,
        ];

        $this->mandatoryFields = array_values(array_diff($this->mandatoryFields, $ignoreFields));

        return $this;
    }
}
