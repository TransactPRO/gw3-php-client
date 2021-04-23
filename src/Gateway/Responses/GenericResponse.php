<?php

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Responses;

use TransactPro\Gateway\Responses\Parts\Payment\Error;

class GenericResponse
{
    public $error;

    public function __construct(array $rawDecoded = null)
    {
        $this->error = !empty($rawDecoded['error']) ? new Error($rawDecoded['error']) : null;
    }
}
