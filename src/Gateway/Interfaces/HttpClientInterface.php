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

use TransactPro\Gateway\Exceptions\RequestException;
use TransactPro\Gateway\Exceptions\ResponseException;

/**
 * Interface HttpClientInterface
 * All HTTP clients that willing to be used by the library
 * should implement this interface.
 */
interface HttpClientInterface
{
    /**
     * Compose final URL from base URL and given path.
     * NB. /report method URL must be without version!
     * NB. Method should not be used for redirect URLs!
     *
     * @param string $path
     *
     * @return string
     */
    public function createUrl(string $path): string;

    /**
     * Request is a method that do request.
     * Internally, this method should call some Transport that
     * will handle the request.
     *
     * @param string $username Entity ID for authentication (like account GUID)
     * @param string $secret   Secret key for digest verification
     * @param string $method   HTTP methods (GET, POST, ...)
     * @param string $path     path of the resource (/sms)
     * @param string $body     request body
     *
     * @throws RequestException
     * @throws ResponseException
     * @return ResponseInterface
     */
    public function request(string $username, string $secret, string $method, string $path, string $body): ResponseInterface;
}
