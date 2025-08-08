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

class TransactionInfo
{
    public $accountGuid;
    public $acqTerminalId;
    public $acqTransactionId;
    public $amount;
    public $approvalCode;
    public $cardholderName;
    public $currency;
    public $dateFinished;
    public $eciSli;
    public $gatewayTransactionId;
    public $merchantTransactionId;
    public $statusCode;
    public $statusCodeGeneral;
    public $statusText;
    public $statusTextGeneral;

    public function __construct(?array $rawDecoded = null)
    {
        $this->accountGuid = strval($rawDecoded['account-guid'] ?? null);
        $this->acqTerminalId = strval($rawDecoded['acq-terminal-id'] ?? null);
        $this->acqTransactionId = strval($rawDecoded['acq-transaction-id'] ?? null);
        $this->amount = intval($rawDecoded['amount'] ?? null);
        $this->approvalCode = strval($rawDecoded['approval-code'] ?? null);
        $this->cardholderName = strval($rawDecoded['cardholder-name'] ?? null);
        $this->currency = strval($rawDecoded['currency'] ?? null);
        $this->dateFinished = !empty($rawDecoded['date-finished']) ? DateTime::createFromFormat('Y-m-d H:i:s', $rawDecoded['date-finished'], new DateTimeZone('UTC')) : null;
        $this->eciSli = strval($rawDecoded['eci-sli'] ?? null);
        $this->gatewayTransactionId = strval($rawDecoded['gateway-transaction-id'] ?? null);
        $this->merchantTransactionId = strval($rawDecoded['merchant-transaction-id'] ?? null);
        $this->statusCode = intval($rawDecoded['status-code'] ?? null);
        $this->statusCodeGeneral = intval($rawDecoded['status-code-general'] ?? null);
        $this->statusText = strval($rawDecoded['status-text'] ?? null);
        $this->statusTextGeneral = strval($rawDecoded['status-text-general'] ?? null);
    }
}
