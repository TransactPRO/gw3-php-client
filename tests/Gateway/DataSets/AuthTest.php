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

class AuthTest extends TestCase
{
    public function testSuccess()
    {
        $expected = [
            DataSet::AUTH_DATA_ACCOUNT_GUID => '3383e58e-9cde-4ffa-85cf-81cd25b2423e',
            DataSet::AUTH_DATA_SECRET_KEY   => 'aaaa',
            DataSet::AUTH_DATA_SESSION_ID   => 'foo',
        ];

        $auth = new Auth();
        $generated = $auth->setAccountGUID('3383e58e-9cde-4ffa-85cf-81cd25b2423e')
            ->setSecretKey('aaaa')
            ->setSessionID('foo')
            ->getRaw();

        $this->assertEquals($expected, $generated);
    }
}
