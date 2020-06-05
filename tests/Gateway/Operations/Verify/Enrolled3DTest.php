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
use TransactPro\Gateway\DataSets\Verify3dEnrollment;
use TransactPro\Gateway\Exceptions\ResponseException;
use TransactPro\Gateway\Http\Response;
use TransactPro\Gateway\Validator\Validator;

class Enrolled3DTest extends TestCase
{
    public function testSuccess()
    {
        $expected = [
            DataSet::DATA_PAN => '123123',
            DataSet::DATA_CURRENCY => 'EUR',
            DataSet::DATA_TERMINAL_MID => '0123456',
        ];

        $instance = new Enrolled3D(new Validator(), new Verify3dEnrollment());
        $instance->inputData()
            ->setPAN('123123')
            ->setCurrency('EUR')
            ->setTerminalMID('0123456');

        $req = $instance->build();

        $this->assertEquals("POST", $req->getMethod());
        $this->assertEquals("/verify/3d-enrollment", $req->getPath());
        $this->assertEquals($expected, $req->getData());
    }

    /**
     * @dataProvider getEnrollmentTestData
     *
     * @param $body
     * @param $expectedResult
     *
     * @throws ResponseException
     */
    public function testParseEnrollmentResponse($body, $expectedResult)
    {
        $instance = new Enrolled3D(new Validator(), new Verify3dEnrollment());
        $parsedResponse = $instance->parseResponse(new Response(200, $body));
        $this->assertEquals($expectedResult, $parsedResponse->enrollment);
    }

    public function getEnrollmentTestData()
    {
        return [
            ["{\"enrollment\":\"y\"}", true],
            ["{\"enrollment\":\"n\"}", false],
            ["{\"enrollment\":\"abracadabra\"}", false],
        ];
    }
}
