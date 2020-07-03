<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Http\Crypto;

abstract class Digest
{
    const QOP_AUTH = 'auth';
    const QOP_AUTH_INT = 'auth-int';

    const ALGORITHM_SHA256 = 'SHA-256';
    const ALGORITHMS_MAP = ['sha-256' => 'sha256'];

    protected $username;
    protected $uri;
    protected $qop;
    protected $algorithm;
    protected $cnonce;
    protected $response;

    protected $body;

    protected function getHmacAlgorithm(string $rawAlgorithm): string
    {
        return self::ALGORITHMS_MAP[ strtolower($rawAlgorithm) ] ?? 'sha256';
    }

    /**
     * @param string $body
     */
    public function setBody(string $body)
    {
        $this->body = $body;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getQop()
    {
        return $this->qop;
    }

    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    public function getCnonce()
    {
        return $this->cnonce;
    }

    public function getResponse()
    {
        return $this->response;
    }
}
