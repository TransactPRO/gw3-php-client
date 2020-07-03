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
use TransactPro\Gateway\DataSets\Money;
use TransactPro\Gateway\DataSets\Order;
use TransactPro\Gateway\Exceptions\ResponseException;
use TransactPro\Gateway\Interfaces\OperationInterface;
use TransactPro\Gateway\Interfaces\ResponseInterface;
use TransactPro\Gateway\Operations\Operation;
use TransactPro\Gateway\Responses\PaymentResponse;
use TransactPro\Gateway\Validator\Validator;

/**
 * Class RecurrentSms.
 *
 * This class describes dataset to perform RECURRENT SMS request.
 * Refer to official documentation for more information about RECURRENT SMS request.
 */
class RecurrentSms extends Operation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    protected $path = '/recurrent/sms';

    /**
     * {@inheritdoc}
     */
    protected $method = 'POST';

    /**
     * {@inheritdoc}
     */
    protected $mandatoryFields = [
        DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_ID,
        DataSet::MONEY_DATA_AMOUNT,
    ];

    /**
     * @var Money
     */
    private $money;

    /**
     * @var Command
     */
    private $command;

    /**
     * @var Order
     */
    private $order;

    /**
     * RecurrentSms constructor.
     * @param Validator $validator
     * @param Money     $money
     * @param Command   $command
     * @param Order     $order
     */
    public function __construct(Validator $validator, Money $money, Command $command, Order $order)
    {
        $this->validator = $validator;

        $this->money = $money;
        $this->command = $command;
        $this->order = $order;

        $this->dataSets = [$this->money, $this->command, $this->order];
    }

    /**
     * @return Command
     */
    public function command()
    {
        return $this->command;
    }

    /**
     * @return Money
     */
    public function money()
    {
        return $this->money;
    }

    /**
     * @return Order
     */
    public function Order()
    {
        return $this->order;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return PaymentResponse
     * @throws ResponseException
     */
    public function parseResponse(ResponseInterface $response): PaymentResponse
    {
        return $response->parseJSON(PaymentResponse::class);
    }
}
