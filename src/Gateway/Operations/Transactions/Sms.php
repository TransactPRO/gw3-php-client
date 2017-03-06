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

use TransactPro\Gateway\DataSets\Customer;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\DataSets\Money;
use TransactPro\Gateway\DataSets\Order;
use TransactPro\Gateway\DataSets\PaymentMethod;
use TransactPro\Gateway\DataSets\System;
use TransactPro\Gateway\Interfaces\OperationInterface;
use TransactPro\Gateway\Operations\Operation;
use TransactPro\Gateway\Validator\Validator;

/**
 * Class Sms.
 *
 * This class describes dataset to perform SMS request.
 * Refer to official documentation for more information about SMS request.
 */
class Sms extends Operation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    protected $path = '/sms';

    /**
     * {@inheritdoc}
     */
    protected $method = 'POST';

    /**
     * {@inheritdoc}
     */
    protected $mandatoryFields = [
        DataSet::PAYMENT_METHOD_DATA_PAN,
        DataSet::PAYMENT_METHOD_DATA_EXPIRE,
        DataSet::PAYMENT_METHOD_DATA_CVV,
        DataSet::MONEY_DATA_AMOUNT,
        DataSet::MONEY_DATA_CURRENCY,
    ];

    /**
     * @var PaymentMethod
     */
    private $paymentMethod;

    /**
     * @var Money
     */
    private $money;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var Order
     */
    private $order;

    /**
     * @var System
     */
    private $system;

    /**
     * Sms constructor.
     * @param Validator     $validator
     * @param PaymentMethod $paymentMethod
     * @param Money         $money
     * @param Customer      $customer
     * @param Order         $order
     * @param System        $system
     */
    public function __construct(Validator $validator, PaymentMethod $paymentMethod, Money $money, Customer $customer, Order $order, System $system)
    {
        $this->validator = $validator;

        $this->paymentMethod = $paymentMethod;
        $this->money = $money;
        $this->customer = $customer;
        $this->order = $order;
        $this->system = $system;

        $this->dataSets = [$this->paymentMethod, $this->money, $this->customer, $this->order, $this->system];
    }

    /**
     * @return PaymentMethod
     */
    public function paymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @return Money
     */
    public function money()
    {
        return $this->money;
    }

    /**
     * @return Customer
     */
    public function customer()
    {
        return $this->customer;
    }

    /**
     * @return Order
     */
    public function order()
    {
        return $this->order;
    }

    /**
     * @return System
     */
    public function system()
    {
        return $this->system;
    }
}
