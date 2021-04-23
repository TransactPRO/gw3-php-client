<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations\Transactions;

use TransactPro\Gateway\DataSets\Command;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\DataSets\Order;
use TransactPro\Gateway\Exceptions\ResponseException;
use TransactPro\Gateway\Interfaces\OperationInterface;
use TransactPro\Gateway\Interfaces\ResponseInterface;
use TransactPro\Gateway\Operations\Operation;
use TransactPro\Gateway\Responses\PaymentResponse;
use TransactPro\Gateway\Validator\Validator;

/**
 * Class Reversal.
 *
 * This class describes dataset to perform REVERSAL request.
 * Refer to official documentation for more information about REVERSAL request.
 */
class Reversal extends Operation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    protected $path = '/reversal';

    /**
     * {@inheritdoc}
     */
    protected $method = 'POST';

    /**
     * {@inheritdoc}
     */
    protected $mandatoryFields = [
        DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_ID,
    ];

    /**
     * @var Command
     */
    private $command;

    /**
     * @var Order
     */
    private $order;

    /**
     * Refund constructor.
     *
     * @param Validator $validator
     * @param Command   $command
     * @param Order     $order
     */
    public function __construct(Validator $validator, Command $command, Order $order)
    {
        $this->validator = $validator;

        $this->command = $command;
        $this->order = $order;

        $this->dataSets = [$this->command, $this->order];
    }

    /**
     * @return Command
     */
    public function command()
    {
        return $this->command;
    }

    /**
     * @return Order
     */
    public function order()
    {
        return $this->order;
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws ResponseException
     * @return PaymentResponse
     */
    public function parseResponse(ResponseInterface $response): PaymentResponse
    {
        return $response->parseJSON(PaymentResponse::class);
    }
}
