<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations\Info;

use TransactPro\Gateway\DataSets\Info;
use TransactPro\Gateway\Interfaces\OperationInterface;
use TransactPro\Gateway\Operations\Operation;
use TransactPro\Gateway\Validator\Validator;

/**
 * Class Refunds.
 *
 *
 * This class describes dataset to perform REFUNDS request.
 * Refer to official documentation for more information about REFUNDS request.
 */
class Refunds extends Operation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    protected $method = 'POST';

    /**
     * {@inheritdoc}
     */
    protected $path = '/refunds';

    /**
     * @var Info
     */
    private $info;

    /**
     * Refunds constructor.
     *
     * @param Validator $validator
     * @param Info      $info
     */
    public function __construct(Validator $validator, Info $info)
    {
        $this->validator = $validator;
        $this->info = $info;

        $this->dataSets = [$this->info];
    }

    /**
     * @return Info
     */
    public function info()
    {
        return $this->info;
    }
}
