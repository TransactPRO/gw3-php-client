<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Operations\Reporting;

use PHPUnit\Framework\TestCase;
use TransactPro\Gateway\DataSets\DataSet;
use TransactPro\Gateway\DataSets\FilterData;
use TransactPro\Gateway\Http\Response;
use TransactPro\Gateway\Validator\Validator;

class ReportTest extends TestCase
{
    public function testReportSuccessFullData()
    {
        $expected = [
            DataSet::FILTER_DATA_DT_CREATED_FROM => 1,
            DataSet::FILTER_DATA_DT_CREATED_TO => 2,
            DataSet::FILTER_DATA_DT_FINISHED_FROM => 3,
            DataSet::FILTER_DATA_DT_FINISHED_TO => 4,
        ];

        $report = new Report(new Validator(), new FilterData());
        $report->filterData()
            ->setDtCreatedFrom(1)
            ->setDtCreatedTo(2)
            ->setDtFinishedFrom(3)
            ->setDtFinishedTo(4);

        $raw = $report->build();

        $this->assertEquals("POST", $raw->getMethod());
        $this->assertEquals("/report", $raw->getPath());
        $this->assertEquals($expected, $raw->getData());
    }

    public function testReportSuccessMinimalData()
    {
        $report = new Report(new Validator(), new FilterData());

        $raw = $report->build();

        $this->assertEquals("POST", $raw->getMethod());
        $this->assertEquals("/report", $raw->getPath());
        $this->assertEquals([], $raw->getData());
    }

    public function testParseCsvResponse()
    {
        $expected = [
            ["aaa" => "1", "bbb" => "2", "ccc" => "3"],
            ["aaa" => "xxx", "bbb" => "yyyy", "ccc" => "zzz"],
        ];

        $body = "aaa,bbb,ccc\n" .
            "1,2,3\n" .
            "xxx,yyyy,zzz\n" .
            "\n";

        $report = new Report(new Validator(), new FilterData());
        $parsedResponse = $report->parseResponse(new Response(200, $body));

        $rows = 0;
        foreach ($parsedResponse as $key => $record) {
            $this->assertArrayHasKey($key, $expected, "Missing value for {$key} in row " . json_encode($record));
            $this->assertEquals($expected[ $key ], $record, "Wrong value for {$key} in row " . json_encode($record));

            $rows++;
        }

        $this->assertEquals(count($expected), $rows, "Not all expected values are present");
        $this->assertFalse($parsedResponse->valid(), "Parsed response contains extra values");
    }
}
