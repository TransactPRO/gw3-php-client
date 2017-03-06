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
    public function testSuccess()
    {
        $expected = [
            DataSet::SYSTEM_USER_IP => '127.0.0.1',
            DataSet::SYSTEM_X_FORWARDED_FOR => '127.0.0.2',
        ];

        $system = new System();

        $raw = $system->setUserIP('127.0.0.1')
            ->setXForwardedFor('127.0.0.2')
            ->getRaw();

        $this->assertEquals($expected, $raw);
    }
}
