<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Responses\Parts\Payment;

class GW
{
    public $gatewayTransactionId;
    public $merchantTransactionId;
    public $originalGatewayTransactionId;
    public $parentGatewayTransactionId;
    public $redirectUrl;
    public $statusCode;
    public $statusText;

    public function __construct(?array $rawDecoded = null)
    {
        $this->gatewayTransactionId = strval($rawDecoded['gateway-transaction-id'] ?? null);
        $this->merchantTransactionId = strval($rawDecoded['merchant-transaction-id'] ?? null);
        $this->originalGatewayTransactionId = strval($rawDecoded['original-gateway-transaction-id'] ?? null);
        $this->parentGatewayTransactionId = strval($rawDecoded['parent-gateway-transaction-id'] ?? null);
        $this->redirectUrl = strval($rawDecoded['redirect-url'] ?? null);
        $this->statusCode = intval($rawDecoded['status-code'] ?? null);
        $this->statusText = strval($rawDecoded['status-text'] ?? null);
    }
}
