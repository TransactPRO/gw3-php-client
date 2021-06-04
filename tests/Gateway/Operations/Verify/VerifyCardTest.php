<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations\Verify;

use PHPUnit\Framework\TestCase;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\DataSets\VerifyCardData;
use TransactPro\Gateway\Validator\Validator;

class VerifyCardTest extends TestCase
{
    public function testSuccess(): void
    {
        $expected = [
            DataSet::DATA_GATEWAY_TRANSACTION_ID => '0123456',
        ];

        $instance = new VerifyCard(new Validator(), new VerifyCardData());
        $instance->data()->setGatewayTransactionID('0123456');

        $req = $instance->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/verify/card", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }
}
