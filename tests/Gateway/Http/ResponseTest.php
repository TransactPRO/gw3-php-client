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

class ResponseTest extends TestCase
{
    public function testSuccess(): void
    {
        $resp = new Response(200, "some answer");

        $resp->setHeader("Content-Type", "application/json");

        $this->assertEquals(200, $resp->getStatusCode());
        $this->assertEquals("some answer", $resp->getBody());
        $this->assertEquals(["Content-Type" => "application/json"], $resp->getHeaders());
        $this->assertEquals("application/json", $resp->getHeader("content-type"));
    }

    public function testIsSuccessful()
    {
        $this->assertTrue((new Response(200, "doesn't matter"))->isSuccessful());
        $this->assertTrue((new Response(201, "doesn't matter"))->isSuccessful());
        $this->assertTrue((new Response(302, "doesn't matter"))->isSuccessful());
        $this->assertTrue((new Response(402, "doesn't matter"))->isSuccessful());

        $this->assertFalse((new Response(404, "doesn't matter"))->isSuccessful());
        $this->assertFalse((new Response(401, "doesn't matter"))->isSuccessful());
        $this->assertFalse((new Response(403, "doesn't matter"))->isSuccessful());
        $this->assertFalse((new Response(500, "doesn't matter"))->isSuccessful());
    }
}
