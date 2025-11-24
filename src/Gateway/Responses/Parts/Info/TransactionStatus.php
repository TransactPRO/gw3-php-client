<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Responses\Parts\Info;

use TransactPro\Gateway\Responses\Parts\Payment\Error;

class TransactionStatus
{
    public $error;
    public $gatewayTransactionId;

    public $statusCode;
    public $statusCodeGeneral;
    public $statusText;
    public $statusTextGeneral;

    public $cardFamily;
    public $cardMask;

    public function __construct(?array $rawDecoded = null)
    {
        $this->error = !empty($rawDecoded['error']) ? new Error($rawDecoded['error']) : null;
        $this->gatewayTransactionId = strval($rawDecoded['gateway-transaction-id'] ?? null);

        $this->statusCode = intval($rawDecoded['status'][0]['status-code'] ?? null);
        $this->statusCodeGeneral = intval($rawDecoded['status'][0]['status-code-general'] ?? null);
        $this->statusText = strval($rawDecoded['status'][0]['status-text'] ?? null);
        $this->statusTextGeneral = strval($rawDecoded['status'][0]['status-text-general'] ?? null);

        $this->cardFamily = strval($rawDecoded['status'][0]['card-family'] ?? null);
        $this->cardMask = strval($rawDecoded['status'][0]['card-mask'] ?? null);
    }
}
