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

/**
 * Class Request.
 *
 * Gateway is doing requests using this class.
 */
class Request
{
    /**
     * HTTP method (ex.: GET, POST, ...)
     *
     * @var string
     */
    private $method;

    /**
     * Path of request (ex.: /sms)
     *
     * @var string
     */
    private $path;

    /**
     * Prepared data for request formatted as
     * `$key => $value`.
     *
     * @var array
     */
    private $data;

    /**
     * Raw body that will be sent to the gateway (JSON string)
     *
     * @var string
     */
    private $preparedData;

    /**
     * Request constructor.
     *
     * @param string $method HTTP method
     * @param string $path   Request path
     * @param array  $data   Prepared data
     */
    public function __construct($method, $path, array $data)
    {
        $this->method = $method;
        $this->path = $path;
        $this->data = $data;
    }

    /**
     * Get request method.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get request path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get request data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set prepared JSON string.
     *
     * @param $preparedData string
     */
    public function setPreparedData($preparedData)
    {
        $this->preparedData = $preparedData;
    }

    /**
     * Get prepared JSON string.
     *
     * @return string
     */
    public function getPreparedData()
    {
        return $this->preparedData;
    }
}
