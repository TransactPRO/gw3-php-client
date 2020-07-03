<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Http\Client;

use TransactPro\Gateway\Exceptions\RequestException;
use TransactPro\Gateway\Http\Crypto\RequestDigest;
use TransactPro\Gateway\Http\Crypto\ResponseDigest;
use TransactPro\Gateway\Http\Response;
use TransactPro\Gateway\Interfaces\HttpClientInterface;
use TransactPro\Gateway\Interfaces\HttpTransportInterface;
use TransactPro\Gateway\Interfaces\ResponseInterface;

class Client implements HttpClientInterface
{
    /**
     * Base URL gateway API URL.
     *
     * @var string
     */
    private $baseUrl;

    /**
     * Gateway API version.
     *
     * @var string
     */
    private $version;

    /**
     * Transport which will actually do the request.
     *
     * @var HttpTransportInterface
     */
    private $transport;

    /**
     * Curl constructor.
     *
     * @param string                 $url           Full URL of the resource
     * @param HttpTransportInterface $httpTransport Transport
     */
    public function __construct($url, HttpTransportInterface $httpTransport)
    {
        $parsedUrl = parse_url($url);

        $this->baseUrl = $url;
        $this->version = $parsedUrl['path'] ?? $url;
        if ($this->baseUrl === $this->version) {
            $this->version = '';
        } else {
            $this->baseUrl = str_replace($this->version, '', $this->baseUrl);
        }

        $this->transport = $httpTransport;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function createUrl(string $path): string
    {
        if ($path === '/report') {
            return "{$this->baseUrl}{$path}";
        }

        return "{$this->baseUrl}{$this->version}{$path}";
    }

    /**
     * {@inheritdoc}
     */
    public function request(string $username, string $secret, string $method, string $fullUrl, string $body): ResponseInterface
    {
        $this->transport->init();

        $digest = new RequestDigest($username, $secret, $fullUrl);
        $digest->setBody($body);
        $authorizationHeader = $digest->createHeader();

        $ok = $this->transport->execute($method, $fullUrl, $authorizationHeader, $body);
        if (!$ok) {
            throw new RequestException($this->transport->error());
        }

        $resp = new Response($this->transport->getStatus(), $this->transport->getBody());
        foreach ($this->transport->getHeaders() as $k => $v) {
            $resp->setHeader($k, $v);
        }

        $this->transport->close();
        if ($resp->isSuccessful()) {
            $responseDigest = new ResponseDigest($resp->getHeader('authorization'));
            $resp->setDigest($responseDigest);

            $responseDigest->setOriginalUri($digest->getUri());
            $responseDigest->setOriginalCnonce($digest->getCnonce());
            $responseDigest->setBody($resp->getBody());
            $responseDigest->verify($username, $secret);
        }

        return $resp;
    }
}
