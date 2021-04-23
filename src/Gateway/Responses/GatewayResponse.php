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

use TransactPro\Gateway\Exceptions\ResponseException;

class GatewayResponse
{
    public static function createFromJSON(string $input, string $responseClass)
    {
        $parsed = json_decode($input, true);
        if (json_last_error() != JSON_ERROR_NONE || !is_array($parsed)) {
            throw new ResponseException(sprintf('Cannot parse JSON: %s.', json_last_error_msg()));
        }

        return new $responseClass($parsed);
    }
}
