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

class Verify3dEnrollmentTest extends TestCase
{
    public function testSuccess()
    {
        $expected = [
            DataSet::DATA_PAN => '123123',
            DataSet::DATA_TERMINAL_MID => '123',
            DataSet::DATA_CURRENCY => 'EUR',
        ];

        $instance = new Verify3dEnrollment();
        $raw = $instance
            ->setPAN('123123')
            ->setTerminalMID('123')
            ->setCurrency('EUR')
            ->getRaw();

        $this->assertEquals($expected, $raw);
    }
}
