<?php declare(strict_types=1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Responses\Parts\Info;

class ObjectLimits
{
    public $type;
    public $title;
    public $acqTerminalId;
    public $limits = [];
    public $children = [];

    public function __construct(?array $rawDecoded = null)
    {
        $this->type = strval($rawDecoded['type'] ?? null);
        $this->title = strval($rawDecoded['title'] ?? null);
        $this->acqTerminalId = strval($rawDecoded['acq-terminal-id'] ?? null);

        if (!empty($rawDecoded['counters']) && is_array($rawDecoded['counters'])) {
            $this->limits = array_map(function ($v) {
                return new Limit($v ?? null);
            }, $rawDecoded['counters']);
        }

        if (!empty($rawDecoded['childs']) && is_array($rawDecoded['childs'])) {
            $this->children = array_map(function ($v) {
                return new ObjectLimits($v ?? null);
            }, $rawDecoded['childs']);
        }
    }
}
