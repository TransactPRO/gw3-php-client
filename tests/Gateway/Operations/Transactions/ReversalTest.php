<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations\Transactions;

use PHPUnit\Framework\TestCase;
use TransactPro\Gateway\DataSets\Command;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\Exceptions\ValidatorException;
use TransactPro\Gateway\Validator\Validator;

class ReversalTest extends TestCase
{
    public function testRefundSuccess()
    {
        $expected = [
            DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_ID => 'qwe123',
        ];

        $refund = new Reversal(new Validator(), new Command());

        $refund->command()->setGatewayTransactionID('qwe123');

        $res = $refund->build();

        $this->assertEquals("POST", $res->getMethod());
        $this->assertEquals("/reversal", $res->getPath());
        $this->assertEquals($expected, $res->getData());
    }

    public function testRefundValidatorException()
    {
        $this->expectException(ValidatorException::class);

        $refund = new Reversal(new Validator(), new Command());

        $refund->build();
    }
}
