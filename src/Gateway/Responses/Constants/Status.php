<?php declare(strict_types = 1);

/*
 * This file is part of the transact-pro/gw3-client package.
 *
 * (c) Transact Pro
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TransactPro\Gateway\Responses\Constants;

class Status
{
    const INIT = 1;
    const SENT2BANK = 2;
    const DMS_HOLD_OK = 3;
    const DMS_HOLD_FAILED = 4;
    const SMS_FAILED = 5;
    const DMS_CHARGE_FAILED = 6;
    const SUCCESS = 7;
    const EXPIRED = 8;
    const HOLD_EXPIRED = 9;
    const REFUND_FAILED = 11;
    const REFUND_PENDING = 12;
    const REFUND_SUCCESS = 13;
    const CARDHOLDER_ONSITE = 14;
    const DMS_CANCELED_OK = 15;
    const DMS_CANCELED_FAILED = 16;
    const REVERSED = 17;
    const INPUT_VALIDATION_FAILED = 18;
    const BR_VALIDATION_FAILED = 19;
    const TG_SELECT_FAILED = 20;
    const T_SELECT_FAILED = 21;
    const INIT_PARAMS_INVALID = 22;
    const DECLINED_BY_BR_ACTION = 23;
    const CALLBACK_URL_GENERATED = 24;
    const WAITING_CARD_FORM_FILL = 25;
    const MPI_URL_GENERATED = 26;
    const WAITING_MPI = 27;
    const MPI_FAILED = 28;
    const MPI_NOT_REACHABLE = 29;
    const CARD_FORM_URL_SENT = 30;
    const MPI_AUTH_ERROR = 31;
    const ACQUIRER_NOT_REACHABLE = 32;
    const REVERSAL_FAILED = 33;
    const CREDIT_FAILED = 34;
    const P2P_FAILED = 35;
    const B2P_FAILED = 36;
    const TOKEN_CREATED = 37;
    const TOKEN_CREATE_FAILED = 38;
}
