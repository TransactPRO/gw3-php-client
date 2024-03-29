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

class CommandTest extends TestCase
{
    public function testSuccess(): void
    {
        $expected = [
            DataSet::COMMAND_DATA_FORM_ID => 'a',
            DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_ID => 'b',
            DataSet::COMMAND_DATA_TERMINAL_MID => 'c',
            DataSet::COMMAND_DATA_CARD_VERIFICATION => 123,
        ];

        $command = new Command();
        $raw = $command->setFormID('a')
            ->setGatewayTransactionID('b')
            ->setTerminalMID('c')
            ->setCardVerificationMode(123)
            ->getRaw();

        $this->assertEquals($expected, $raw);
    }
}
