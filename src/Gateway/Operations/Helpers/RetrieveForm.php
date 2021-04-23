<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations\Helpers;

use TransactPro\Gateway\Exceptions\RequestException;
use TransactPro\Gateway\Interfaces\OperationInterface;
use TransactPro\Gateway\Operations\Operation;
use TransactPro\Gateway\Responses\PaymentResponse;
use TransactPro\Gateway\Validator\Validator;

/**
 * Class RetrieveForm.
 *
 * This class describes dataset to load HTML form intended for a cardholder.
 * Refer to official documentation for more information about possible usage.
 *
 * NB. Use this only if you are sure about what you are doing.
 */
class RetrieveForm extends Operation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    protected $method = 'GET';

    /**
     * RetrieveForm constructor.
     *
     * @param Validator       $validator
     * @param PaymentResponse $paymentResponse
     *
     * @throws RequestException
     */
    public function __construct(Validator $validator, PaymentResponse $paymentResponse)
    {
        $this->validator = $validator;

        if (empty($paymentResponse->gw->redirectUrl)) {
            throw new RequestException("Response doesn't contain link to an HTML form");
        }

        $this->path = $paymentResponse->gw->redirectUrl;
    }
}
