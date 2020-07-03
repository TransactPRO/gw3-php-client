<?php

namespace TransactPro\Gateway\Responses;

use TransactPro\Gateway\Responses\Parts\Payment\Error;

class GenericResponse
{
    public $error;

    public function __construct(array $rawDecoded = null) {
        $this->error = !empty($rawDecoded['error']) ? new Error($rawDecoded['error']) : null;
    }
}
