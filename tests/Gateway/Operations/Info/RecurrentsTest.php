<?php

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations\Info;

use PHPUnit\Framework\TestCase;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\DataSets\Info;
use TransactPro\Gateway\Validator\Validator;

class RecurrentsTest extends TestCase
{
    public function testSuccess()
    {
        $expected = [
            DataSet::COMMAND_DATA_GATEWAY_TRANSACTION_IDS => ['123'],
            DataSet::COMMAND_DATA_MERCHANT_TRANSACTION_IDS => ['123'],
        ];

        $status = new Recurrents(new Validator(), new Info());
        $status->info()
            ->setGatewayTransactionIDs(['123'])
            ->setMerchantTransactionIDs(['123']);

        $req = $status->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/recurrents", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }
}
