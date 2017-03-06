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
 * Interface HttpTransportInterface.
 *
 * HttpTransportInterface describe methods used
 * by HTTP Client to perform request.
 */
interface HttpTransportInterface
{
    /**
     * Initialize request.
     *
     * Open connection to some resource.
     *
     * @return void
     */
    public function init();

    /**
     * @param  string $method HTTP method (GET, POST, ...)
     * @param  string $url    URL (https://api.transactpro.lv/version) without trailing slash (/)
     * @param  string $body   Body of the request
     * @return bool
     */
    public function execute(string $method, string $url, string $body): bool;

    public function close();

    public function getStatus(): int;

    public function getHeaders(): array;

    public function getBody(): string;

    public function error(): string;
}
