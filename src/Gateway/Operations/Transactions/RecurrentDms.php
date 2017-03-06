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
use TransactPro\Gateway\Interfaces\OperationInterface;
use TransactPro\Gateway\Operations\Operation;
use TransactPro\Gateway\Validator\Validator;

/**
 * Class RecurrentDms.
 *
 * This class describes dataset to perform RECURRENT DMS request.
 * Refer to official documentation for more information about RECURRENT DMS request.
 */
class RecurrentDms extends Operation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    protected $path = '/recurrent/dms';

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
     * RecurrentDms constructor.
     * @param Validator $validator
     * @param Money     $money
     * @param Command   $command
     */
    public function __construct(Validator $validator, Money $money, Command $command)
    {
        $this->validator = $validator;

        $this->money = $money;
        $this->command = $command;

        $this->dataSets = [$this->money, $this->command];
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
}
