<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Responses;

use Iterator;
use TransactPro\Gateway\Exceptions\ResponseException;

class CsvResponse implements Iterator
{
    private $data;
    private $stream;
    private $headers = [];

    private $index = -1;
    private $status = false;
    private $current;

    /**
     * @param string $data Raw CSV data that must contain a row with headers and, possibly, data rows
     *
     * @throws ResponseException
     */
    public function __construct(string $data)
    {
        $this->data = $data;
        $this->openStream();

        $rawHeaders = fgets($this->stream);
        if ($rawHeaders === false) {
            throw new ResponseException('Cannot parse CSV data: no headers line');
        }

        $this->headers = str_getcsv($rawHeaders);
        $this->next();
    }

    /**
     * @throws ResponseException
     */
    private function openStream()
    {
        $this->stream = fopen('data://text/plain,' . $this->data, 'r');
        if ($this->stream === false) {
            $this->stream = null;
            throw new ResponseException('Cannot parse CSV data');
        }
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function current()
    {
        return $this->current;
    }

    public function next()
    {
        $this->index++;

        do {
            $rawLine = fgets($this->stream);
        } while ($rawLine === '' || $rawLine === "\n");

        if ($rawLine === false) {
            $this->status = false;
            fclose($this->stream);
            $this->stream = null;

            return;
        }

        $data = str_getcsv(trim($rawLine, "\n"));
        $this->current = array_combine($this->headers, $data);
        $this->status = true;
    }

    public function key()
    {
        return $this->index;
    }

    public function valid()
    {
        return $this->status;
    }

    /**
     * @throws ResponseException
     */
    public function rewind()
    {
        if ($this->stream === null) {
            $this->openStream();
        } else {
            rewind($this->stream);
        }

        fgets($this->stream); // skip headers line
        $this->index = -1;
        $this->next();
    }
}
