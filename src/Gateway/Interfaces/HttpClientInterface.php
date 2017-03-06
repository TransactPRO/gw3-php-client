<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Interfaces;

/**
 * Interface HttpClientInterface
 *
 * All HTTP clients that willing to be used by the library
 * should implement this interface.
 */
interface HttpClientInterface
{
    /**
     * Request is a method that do request.
     *
     * Internally, this method should call some Transport that
     * will handle the request.
     *
     * @param string $method HTTP methods (GET, POST, ...)
     * @param string $path   path of the resource (/sms)
     * @param string $body   request body
     *
     * @return ResponseInterface
     */
    public function request(string $method, string $path, string $body): ResponseInterface;
}
