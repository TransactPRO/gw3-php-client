<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Responses;

use TransactPro\Gateway\Responses\Parts\Payment\AcquirerDetails;
use TransactPro\Gateway\Responses\Parts\Payment\GW;

class PaymentResponse extends GenericResponse
{
    public $acquirerDetails;
    public $gw;
    public $warnings;

    public function __construct(array $rawDecoded = null)
    {
        parent::__construct($rawDecoded);
        $this->acquirerDetails = !empty($rawDecoded['acquirer-details']) ? new AcquirerDetails($rawDecoded['acquirer-details']) : null;
        $this->gw = !empty($rawDecoded['gw']) ? new GW($rawDecoded['gw']) : null;
        $this->warnings = $rawDecoded['warnings'] ?? [];
    }
}
