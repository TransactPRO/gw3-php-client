<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Http;

use TransactPro\Gateway\Interfaces\ResponseInterface;

/**
 * Class Response.
 *
 * Response is a class that implements ResponseInterface
 * and will be returned on all Gateway requests.
 */
class Response implements ResponseInterface
{
    /**
     * HTTP Status Code
     *
     * @var int
     */
    private $status;

    /**
     * Body of the response
     *
     * @var string
     */
    private $body;

    /**
     * List of of original Headers as
     * list `$header => $value`.
     *
     * @var array
     */
    private $headers = [];

    /**
     * List of normalized header names on
     * original names as list `$normalized => $header`.
     *
     * @var array
     */
    private $headerNames = [];

    /**
     * Response constructor.
     *
     * @param int    $status HTTP Status code
     * @param string $body   Response body
     */
    public function __construct($status, $body)
    {
        $this->status = (int) $status;
        $this->body = $body;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode(): int
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setHeader(string $header, string $value): ResponseInterface
    {
        $normalized = strtolower($header);
        $value = $this->trimHeaderValue($value);

        $this->headers[$header] = $value;
        $this->headerNames[$normalized] = $header;

        return $this;
    }

    /**
     * Trims whitespace from the header values.
     *
     * Spaces and tabs ought to be excluded by parsers when extracting the field value from a header field.
     *
     * header-field = field-name ":" OWS field-value OWS
     * OWS          = *( SP / HTAB )
     *
     * @param string $value Header value
     *
     * @return string Trimmed header value
     *
     * @see https://tools.ietf.org/html/rfc7230#section-3.2.4
     */
    private function trimHeaderValue(string $value): string
    {
        return trim($value, " \t");
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeader(string $header): string
    {
        $normalized = strtolower($header);

        if (!isset($this->headerNames[$normalized])) {
            return "";
        }

        $originalHeader = $this->headerNames[$normalized];

        if (!isset($this->headers[$originalHeader])) {
            return "";
        }

        return $this->headers[$originalHeader];
    }

    /**
     * {@inheritdoc}
     */
    public function getBody(): string
    {
        return $this->body;
    }
}
