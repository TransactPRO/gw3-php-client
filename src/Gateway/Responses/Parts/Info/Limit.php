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

class Limit
{
    public $counterType;
    public $currency;
    public $limit;
    public $paymentMethodSubtype;
    public $paymentMethodType;
    public $value;

    public function __construct(?array $rawDecoded = null)
    {
        $this->counterType = strval($rawDecoded['counter-type'] ?? null);
        $this->currency = strval($rawDecoded['currency'] ?? null);
        $this->limit = intval($rawDecoded['limit'] ?? null);
        $this->paymentMethodSubtype = strval($rawDecoded['payment-method-subtype'] ?? null);
        $this->paymentMethodType = strval($rawDecoded['payment-method-type'] ?? null);
        $this->value = intval($rawDecoded['value'] ?? null);
    }
}
