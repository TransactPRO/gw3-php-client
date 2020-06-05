<?php declare(strict_types=1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Responses;

use TransactPro\Gateway\Responses\Parts\Info\ObjectLimits;

class LimitsResponse extends GenericResponse
{
    public $limits;

    public function __construct(array $rawDecoded = null) {
        parent::__construct($rawDecoded);
        $this->limits = new ObjectLimits($rawDecoded);
    }
}