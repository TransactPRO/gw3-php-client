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

class HistoryEvent
{
    public $dateUpdated;
    public $statusCodeNew;
    public $statusCodeOld;
    public $statusTextNew;
    public $statusTextOld;

    public function __construct(?array $rawDecoded = null)
    {
        $this->dateUpdated = !empty($rawDecoded['date-updated']) ? DateTime::createFromFormat('Y-m-d H:i:s', $rawDecoded['date-updated'], new DateTimeZone('UTC')) : null;
        $this->statusCodeNew = intval($rawDecoded['status-code-new'] ?? null);
        $this->statusCodeOld = intval($rawDecoded['status-code-old'] ?? null);
        $this->statusTextNew = strval($rawDecoded['status-text-new'] ?? null);
        $this->statusTextOld = strval($rawDecoded['status-text-old'] ?? null);
    }
}
