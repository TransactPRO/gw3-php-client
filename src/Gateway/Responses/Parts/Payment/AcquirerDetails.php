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

class AcquirerDetails
{
    public $dynamicDescriptor;
    public $eciSli;
    public $resultCode;
    public $statusDescription;
    public $statusText;
    public $terminalMid;
    public $transactionId;

    public function __construct(array $rawDecoded = null)
    {
        $this->dynamicDescriptor = strval($rawDecoded['dynamic-descriptor'] ?? null);
        $this->eciSli = strval($rawDecoded['eci-sli'] ?? null);
        $this->resultCode = strval($rawDecoded['result-code'] ?? null);
        $this->statusDescription = strval($rawDecoded['status-description'] ?? null);
        $this->statusText = strval($rawDecoded['status-text'] ?? null);
        $this->terminalMid = strval($rawDecoded['terminal-mid'] ?? null);
        $this->transactionId = strval($rawDecoded['transaction-id'] ?? null);
    }
}
