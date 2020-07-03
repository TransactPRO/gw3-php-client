<?php

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
