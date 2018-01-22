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

/**
 * Class InitRecurrentDms.
 *
 * This class describes dataset to perform Init Recurrent DMS request.
 * Refer to official documentation for more information about Init Recurrent DMS request.
 */
class InitRecurrentDms extends DmsHold
{
    /**
     * {@inheritdoc}
     */
    protected $path = '/recurrent/dms/init';
}
