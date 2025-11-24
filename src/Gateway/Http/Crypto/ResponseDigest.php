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

use TransactPro\Gateway\Exceptions\DigestMismatchException;
use TransactPro\Gateway\Exceptions\DigestMissingException;

class ResponseDigest extends Digest
{
    protected $timestamp;
    protected $snonce;

    protected $originalUri;
    protected $originalCnonce;

    /**
     * @param string|null $authorizationHeader
     *
     * @throws DigestMissingException
     * @throws DigestMismatchException
     */
    public function __construct(?string $authorizationHeader = null)
    {
        if (empty($authorizationHeader)) {
            throw new DigestMissingException();
        }

        $authorizationHeader = trim(str_replace(["\n", "\r"], ['', ''], $authorizationHeader));
        $parts = preg_split('/^digest /i', $authorizationHeader);
        if ($parts === false || count($parts) !== 2 || $parts[0] !== "" || empty($parts[1])) {
            throw new DigestMismatchException("Digest mismatch: wrong type");
        }

        $headerValues = [
            'username' => null,
            'uri' => null,
            'algorithm' => null,
            'cnonce' => null,
            'snonce' => null,
            'qop' => null,
            'response' => null,
        ];
        $parsed = explode(',', $parts[1]);
        foreach ($parsed as $keyValue) {
            $keyValue = trim($keyValue);
            $delimiterPos = strpos($keyValue, '=');
            if ($delimiterPos !== false) {
                $key = substr($keyValue, 0, $delimiterPos);
                if (array_key_exists($key, $headerValues)) {
                    $value = substr($keyValue, $delimiterPos + 1);
                    $headerValues[ $key ] = trim(trim($value, '"'));
                }
            }
        }

        $restrictions = [
            'algorithm' => array_keys(self::ALGORITHMS_MAP),
            'qop' => [self::QOP_AUTH, self::QOP_AUTH_INT],
        ];
        foreach ($headerValues as $key => $value) {
            if (!isset($value) || !is_string($value)) {
                throw new DigestMismatchException("Digest mismatch: empty value for $key");
            }

            if (isset($restrictions[ $key ]) && !in_array(strtolower($value), $restrictions[ $key ], true)) {
                throw new DigestMismatchException("Digest mismatch: invalid value for $key");
            }

            $this->$key = $value;
        }

        if (!empty($this->cnonce)) {
            $this->cnonce = base64_decode($this->cnonce);
        }

        if (!empty($this->snonce)) {
            $this->snonce = base64_decode($this->snonce);

            $timestampDelimiterPos = strpos($this->snonce, ':');
            if ($timestampDelimiterPos === false) {
                throw new DigestMismatchException('Digest mismatch: corrupted value for snonce (missing timestamp)');
            }

            $this->timestamp = substr($this->snonce, 0, $timestampDelimiterPos);
            if (empty($this->timestamp) || !is_numeric($this->timestamp)) {
                throw new DigestMismatchException('Digest mismatch: corrupted value for snonce (unexpected timestamp value)');
            }
        }
    }

    public function setOriginalUri($originalUri)
    {
        $this->originalUri = $originalUri;
    }

    public function setOriginalCnonce($originalCnonce)
    {
        $this->originalCnonce = $originalCnonce;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function getSnonce()
    {
        return $this->snonce;
    }

    /**
     * @param string $objectGUID
     * @param string $secret
     *
     * @throws DigestMismatchException
     */
    public function verify(string $objectGUID, string $secret)
    {
        if (strtolower($objectGUID) != strtolower($this->username)) {
            throw new DigestMismatchException("Digest mismatch: username mismatch");
        }

        if (isset($this->originalUri) && $this->originalUri != $this->uri) {
            throw new DigestMismatchException("Digest mismatch: uri mismatch");
        }

        if (isset($this->originalCnonce) && $this->originalCnonce != $this->cnonce) {
            throw new DigestMismatchException("Digest mismatch: cnonce mismatch");
        }

        $data = "{$this->username}{$this->cnonce}{$this->snonce}{$this->qop}{$this->uri}";
        if ($this->qop === self::QOP_AUTH_INT) {
            $data .= $this->body;
        }
        $expectedDigest = hash_hmac($this->getHmacAlgorithm($this->algorithm), $data, $secret);

        if (!hash_equals($expectedDigest, $this->response)) {
            throw new DigestMismatchException();
        }
    }
}
