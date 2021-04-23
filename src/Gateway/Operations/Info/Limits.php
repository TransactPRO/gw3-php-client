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

use TransactPro\Gateway\Exceptions\ResponseException;
use TransactPro\Gateway\Interfaces\OperationInterface;
use TransactPro\Gateway\Interfaces\ResponseInterface;
use TransactPro\Gateway\Operations\Operation;
use TransactPro\Gateway\Responses\LimitsResponse;
use TransactPro\Gateway\Validator\Validator;

/**
 * Class Limits.
 *
 *
 * This class describes dataset to perform LIMITS request.
 * Refer to official documentation for more information about LIMITS request.
 */
class Limits extends Operation implements OperationInterface
{
    /**
     * {@inheritdoc}
     */
    protected $method = 'POST';

    /**
     * {@inheritdoc}
     */
    protected $path = '/limits';

    /**
     * Refunds constructor.
     *
     * @param Validator $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param ResponseInterface $response
     *
     * @throws ResponseException
     * @return LimitsResponse
     */
    public function parseResponse(ResponseInterface $response): LimitsResponse
    {
        return $response->parseJSON(LimitsResponse::class);
    }
}
