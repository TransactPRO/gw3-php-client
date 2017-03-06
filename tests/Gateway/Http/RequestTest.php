<?php

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Http;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testSuccess()
    {
        $req = new Request("POST", "/test", ["val" => 123]);

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/test", $req->getPath());
        $this->assertEquals(["val" => 123], $req->getData());
    }
}
