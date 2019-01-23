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
use TransactPro\Gateway\Interfaces\OperationInterface;
use TransactPro\Gateway\Operations\Operation;
use TransactPro\Gateway\Validator\Validator;

/**
 * Class DmsCharge.
 *
 * This class describes dataset to perform DMS CHARGE request.
 * Refer to official documentation for more information about DMS CHARGE request.
 */
class DmsCharge extends Operation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    protected $path = "/charge-dms";

    /**
     * {@inheritdoc}
     */
    protected $method = "POST";

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
     * DmsCharge constructor.
     *
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
    public function order()
    {
        return $this->order;
    }
}
