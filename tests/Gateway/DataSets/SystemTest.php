<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\DataSets;

use PHPUnit\Framework\TestCase;

class SystemTest extends TestCase
{
    public function testSuccess(): void
    {
        $expected = [
            DataSet::SYSTEM_USER_IP => '127.0.0.1',
            DataSet::SYSTEM_X_FORWARDED_FOR => '127.0.0.2',
            DataSet::SYSTEM_BROWSER_ACCEPT_HEADER => "application/json, text/javascript, */*; q=0.01",
            DataSet::SYSTEM_BROWSER_JAVA_ENABLED => false,
            DataSet::SYSTEM_BROWSER_JAVASCRIPT_ENABLED => true,
            DataSet::SYSTEM_BROWSER_LANGUAGE => "en-US",
            DataSet::SYSTEM_BROWSER_COLOR_DEPTH => "24",
            DataSet::SYSTEM_BROWSER_SCREEN_HEIGHT => "1080",
            DataSet::SYSTEM_BROWSER_SCREEN_WIDTH => "1920",
            DataSet::SYSTEM_BROWSER_TZ => "+300",
            DataSet::SYSTEM_BROWSER_USER_AGENT => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36",
        ];

        $system = new System();

        $raw = $system->setUserIP('127.0.0.1')
            ->setXForwardedFor('127.0.0.2')
            ->setBrowserAcceptHeader("application/json, text/javascript, */*; q=0.01")
            ->setBrowserJavaEnabled(false)
            ->setBrowserJavaScriptEnabled(true)
            ->setBrowserLanguage("en-US")
            ->setBrowserColorDepth("24")
            ->setBrowserScreenHeight("1080")
            ->setBrowserScreenWidth("1920")
            ->setBrowserTZ("+300")
            ->setUserAgent("Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36")
            ->getRaw();

        $this->assertEquals($expected, $raw);
    }
}
