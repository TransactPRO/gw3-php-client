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

class InitialRecurringTransaction
{
    public $gatewayTransactionId;
    public $error;
    public $subsequent = [];

    public function __construct(array $rawDecoded = null)
    {
        $this->gatewayTransactionId = strval($rawDecoded['gateway-transaction-id'] ?? null);
        $this->error = !empty($rawDecoded['error']) ? new Error($rawDecoded['error']) : null;
        if (!empty($rawDecoded['recurrents']) && is_array($rawDecoded['recurrents'])) {
            $this->subsequent = array_map(function ($v) {
                return new TransactionInfo($v ?? null);
            }, $rawDecoded['recurrents']);
        }
    }
}
