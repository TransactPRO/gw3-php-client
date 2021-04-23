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

use TransactPro\Gateway\Exceptions\ResponseException;
use TransactPro\Gateway\Http\Crypto\ResponseDigest;
use TransactPro\Gateway\Responses\CsvResponse;

/**
 * Interface ResponseInterface.
 */
interface ResponseInterface
{
    /**
     * Will return HTTP Status Code.
     *
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * Will return TRUE if response status code is a successful one
     *
     * @return bool
     */
    public function isSuccessful(): bool;

    /**
     * Set HTTP Header.
     *
     * @param string $header HTTP Header (ex.: "Content-Type")
     * @param string $value  HTTP Header value (ex.: "application/json")
     *
     * @return ResponseInterface
     */
    public function setHeader(string $header, string $value): self;

    /**
     * Get all HTTP headers.
     *
     * Will return array of HTTP headers
     * in the format `$header => $value`
     *
     * @return array
     */
    public function getHeaders(): array;

    /**
     * Get specified HTTP header.
     *
     * @param string $header HTTP Header (ex.: "Content-Type")
     *
     * @return string
     */
    public function getHeader(string $header): string;

    /**
     * Get request body.
     *
     * @return string
     */
    public function getBody(): string;

    /**
     * Get parsed response digest representation object
     *
     * @return ResponseDigest|null
     */
    public function getDigest();

    /**
     * Parse response body as a JSON response
     *
     * @param string $targetClass
     *
     * @throws ResponseException
     * @return mixed
     */
    public function parseJSON(string $targetClass);

    /**
     * Parse response body as a response in CSV format with mandatory headers line
     *
     * @throws ResponseException
     * @return CsvResponse
     */
    public function parseCsv(): CsvResponse;
}
