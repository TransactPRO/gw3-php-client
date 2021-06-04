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

use Exception;
use TransactPro\Gateway\Exceptions\RequestException;

class RequestDigest extends Digest
{
    const NONCE_LENGTH = 32;

    protected $secret;

    /**
     * @param string $username
     * @param string $secret
     * @param string $fullUrl
     *
     * @throws RequestException
     */
    public function __construct(string $username, string $secret, string $fullUrl)
    {
        try {
            $this->username = $username;
            $this->secret = $secret;
            $this->algorithm = self::ALGORITHM_SHA256;
            $this->qop = self::QOP_AUTH_INT;
            $this->cnonce = time() . ':' . random_bytes(self::NONCE_LENGTH);

            $parsedUrl = parse_url($fullUrl);
            $this->uri = $parsedUrl['path'] ?? $fullUrl;
        } catch (Exception $e) {
            throw new RequestException("Cannot create request digest: {$e->getMessage()}", $e->getCode(), $e);
        }
    }

    /**
     * @return string
     */
    public function createHeader(): string
    {
        $data = "{$this->username}{$this->cnonce}{$this->qop}{$this->uri}";
        if ($this->qop === self::QOP_AUTH_INT) {
            $data .= $this->body;
        }

        $this->response = hash_hmac($this->getHmacAlgorithm($this->algorithm), $data, $this->secret);

        return sprintf(
            'Authorization: Digest username=%s, uri="%s", algorithm=%s, cnonce="%s", qop=%s, response="%s"',
            $this->username,
            $this->uri,
            $this->algorithm,
            base64_encode($this->cnonce),
            $this->qop,
            $this->response
        );
    }
}
