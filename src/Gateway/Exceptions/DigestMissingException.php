<?php declare(strict_types = 1);

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
 * Class DigestMissingException
 * DigestMissingException class will be thrown
 * if there is no Authorization header in response.
 */
class DigestMissingException extends ResponseException
{
    public function __construct($message = "Digest is missing", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
