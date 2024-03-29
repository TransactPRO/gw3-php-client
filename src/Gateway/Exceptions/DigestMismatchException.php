<?php declare(strict_types=1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Exceptions;

use Throwable;

/**
 * Class DigestMismatchException
 * DigestMismatchException class will be thrown
 * if digest mismatches expected one
 * or Authorization parameters mismatch original ones.
 */
class DigestMismatchException extends ResponseException
{
    public function __construct($message = "Digest mismatch", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
