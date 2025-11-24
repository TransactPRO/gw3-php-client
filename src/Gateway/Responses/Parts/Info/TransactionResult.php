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

use DateTime;
use DateTimeZone;
use TransactPro\Gateway\Responses\Parts\Payment\Error;
use TransactPro\Gateway\Responses\PaymentResponse;

class TransactionResult
{
    public $dateCreated;
    public $dateFinished;
    public $gatewayTransactionId;
    public $error;
    public $resultData;

    public function __construct(?array $rawDecoded = null)
    {
        $this->dateCreated = !empty($rawDecoded['date-created']) ? DateTime::createFromFormat('Y-m-d H:i:s', $rawDecoded['date-created'], new DateTimeZone('UTC')) : null;
        $this->dateFinished = !empty($rawDecoded['date-finished']) ? DateTime::createFromFormat('Y-m-d H:i:s', $rawDecoded['date-finished'], new DateTimeZone('UTC')) : null;
        $this->gatewayTransactionId = strval($rawDecoded['gateway-transaction-id'] ?? null);
        $this->error = !empty($rawDecoded['error']) ? new Error($rawDecoded['error']) : null;
        $this->resultData = !empty($rawDecoded['result-data']) ? new PaymentResponse($rawDecoded['result-data']) : null;
    }
}
