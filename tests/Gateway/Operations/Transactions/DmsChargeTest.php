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

class DmsChargeTest extends TestCase
{
    public function testDmsCharge()
    {
        $expected = [
            DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_ID => "qwe",
            DataSet::MONEY_DATA_AMOUNT => 100,
        ];

        $dmsCharge = new DmsCharge(new Validator(), new Money(), new Command());

        $dmsCharge->command()
            ->setGatewayTransactionID("qwe");

        $dmsCharge->money()
            ->setAmount(100);

        $req = $dmsCharge->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/charge-dms", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }

    public function testDmsChargeValidatorException()
    {
        $this->expectException(ValidatorException::class);

        $dmsCharge = new DmsCharge(new Validator(), new Money(), new Command());

        $dmsCharge->command()
            ->setGatewayTransactionID("qwe");

        $dmsCharge->build();
    }
}
