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
use TransactPro\Gateway\DataSets\Money;
use TransactPro\Gateway\Exceptions\ValidatorException;
use TransactPro\Gateway\Validator\Validator;

class RecurrentDmsTest extends TestCase
{
    public function testRecurrentDms()
    {
        $expected = [
            DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_ID => 'qwe123qwe',
            DataSet::MONEY_DATA_AMOUNT => 100,
        ];

        $recurrentDms = new RecurrentDms(new Validator(), new Money(), new Command());
        $recurrentDms->command()->setGatewayTransactionID('qwe123qwe');
        $recurrentDms->money()->setAmount(100);

        $req = $recurrentDms->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/recurrent/dms", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }

    public function testRecurrentDmsValidatorException()
    {
        $this->expectException(ValidatorException::class);

        $recurrentDms = new RecurrentDms(new Validator(), new Money(), new Command());

        $recurrentDms->build();
    }
}
