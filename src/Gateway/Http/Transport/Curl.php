<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Http\Transport;

use TransactPro\Gateway\Interfaces\HttpTransportInterface;

/**
 * Class Curl.
 *
 * Curl is a transport for the client.
 */
class Curl implements HttpTransportInterface
{
    /**
     * Response headers as list `$header => $value`.
     *
     * @var array
     */
    private $headers;

    /**
     * Request body.
     *
     * @var string
     */
    private $body;

    /**
     * HTTP Status Code.
     *
     * @var int
     */
    private $status;

    /**
     * cURL resource.
     *
     * @var resource
     */
    private $ch;

    /**
     * Default options for cURL.
     *
     * @var array
     */
    private $options = [
        CURLOPT_FAILONERROR => 1,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_SSL_VERIFYPEER => 1,
        CURLOPT_HEADER => 1,
    ];

    /**
     * Set default options to bootstrap cURL.
     *
     * @return $this
     */
    public function setDefaultOptions()
    {
        foreach ($this->options as $k => $v) {
            $this->setOption($k, $v);
        }

        return $this;
    }

    /**
     * Set option of cURL.
     *
     * @param  mixed $option cURL constant
     * @param  mixed $value  cURL option value
     * @return Curl
     */
    public function setOption($option, $value): self
    {
        $this->options[$option] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->ch = curl_init();
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
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Execute perform request.
     *
     * @param  string $method HTTP method
     * @param  string $url    Full URL of requested resource
     * @param  string $body   Body of the request
     * @return bool
     */
    public function execute(string $method, string $url, string $body): bool
    {
        $this->setOption(CURLOPT_CUSTOMREQUEST, $method)
            ->setOption(CURLOPT_POSTFIELDS, $body)
            ->setOption(CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Expect:'])
            ->setOption(CURLOPT_URL, $url)
            ->applyOptions();

        $result = curl_exec($this->ch);
        if (!$result) {
            return false;
        }

        list($header, $body) = explode("\r\n\r\n", $result, 2);
        $this->body = $body;

        $this->status = (int) curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        $this->headers = $this->headersToArray($header);

        return true;
    }

    /**
     * Update options or set new ones to cURL resource.
     */
    private function applyOptions()
    {
        foreach ($this->options as $o => $v) {
            curl_setopt($this->ch, $o, $v);
        }
    }

    /**
     * Convert string of headers to array
     * in format `$header => $value`.
     *
     * @param  string $header
     * @return array
     */
    private function headersToArray(string $header): array
    {
        $headers = [];

        foreach (explode("\r\n", $header) as $i => $line) {
            if ($i === 0) {
                continue;
            }

            list($key, $value) = explode(': ', $line);

            $headers[$key] = $value;
        }

        return $headers;
    }

    /**
     * {@inheritdoc}
     */
    public function error(): string
    {
        $errNo = curl_errno($this->ch);
        $errMessage = curl_error($this->ch);

        if ($errNo === 0) {
            return "";
        }

        return "[$errNo] $errMessage";
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        if (is_resource($this->ch)) {
            curl_close($this->ch);

            $this->ch = null;
        }
    }
}
