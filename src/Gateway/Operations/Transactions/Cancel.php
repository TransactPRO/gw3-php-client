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
use TransactPro\Gateway\Interfaces\OperationInterface;
use TransactPro\Gateway\Operations\Operation;
use TransactPro\Gateway\Validator\Validator;

/**
 * Class Cancel.
 *
 * This class describes dataset to perform CANCEL request.
 * Refer to official documentation for more information about CANCEL request.
 */
class Cancel extends Operation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    protected $path = "/cancel";

    /**
     * {@inheritdoc}
     */
    protected $method = "POST";

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
     * Cancel constructor.
     *
     * @param Validator $validator
     * @param Command   $command
     */
    public function __construct(Validator $validator, Command $command)
    {
        $this->validator = $validator;

        $this->command = $command;

        $this->dataSets = [$this->command];
    }

    /**
     * @return Command
     */
    public function command()
    {
        return $this->command;
    }
}
