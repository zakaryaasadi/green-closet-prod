<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CREATE_ORDER_MESSAGE()
 * @method static static ASSIGNED_ORDER_MESSAGE()
 * @method static static ACCEPT_ORDER_MESSAGE()
 * @method static static DECLINE_ORDER_MESSAGE()
 * @method static static MAKE_ORDER_MESSAGE()
 * @method static static DELIVERING_ORDER_MESSAGE()
 * @method static static CANCEL_ORDER_MESSAGE()
 * @method static static FAILED_ORDER_MESSAGE()
 * @method static static SUCCESSFUL_ORDER_MESSAGE()
 * @method static static CREATE_ORDER_MESSAGE_TITLE()
 * @method static static ASSIGNED_ORDER_MESSAGE_TITLE()
 * @method static static ACCEPT_ORDER_MESSAGE_TITLE()
 * @method static static DECLINE_ORDER_MESSAGE_TITLE()
 * @method static static MAKE_ORDER_MESSAGE_TITLE()
 * @method static static DELIVERING_ORDER_MESSAGE_TITLE()
 * @method static static CANCEL_ORDER_MESSAGE_TITLE()
 * @method static static FAILED_ORDER_MESSAGE_TITLE()
 * @method static static SUCCESSFUL_ORDER_MESSAGE_TITLE()
 * @method static static OTP_MESSAGE()
 * @method static static THANKS_MESSAGE()
 * @method static static ASSIGNED_ORDER_MESSAGE_AGENT()
 * @method static static FAILED_MESSAGE()
 * @method static static ASSOCIATION_EXPENSES_REQUESTED_MESSAGE()
 * @method static static ASSOCIATION_EXPENSES_REQUESTED_TITLE()
 * @method static static INVOICE_MESSAGE()
 */
class MessageType extends Enum
{
    const CREATE_ORDER_MESSAGE = 1;

    const ASSIGNED_ORDER_MESSAGE = 2;

    const ACCEPT_ORDER_MESSAGE = 3;

    const DECLINE_ORDER_MESSAGE = 4;

    const MAKE_ORDER_MESSAGE = 5;

    const DELIVERING_ORDER_MESSAGE = 6;

    const CANCEL_ORDER_MESSAGE = 7;

    const FAILED_ORDER_MESSAGE = 8;

    const SUCCESSFUL_ORDER_MESSAGE = 9;

    const CREATE_ORDER_MESSAGE_TITLE = 10;

    const ASSIGNED_ORDER_MESSAGE_TITLE = 11;

    const ACCEPT_ORDER_MESSAGE_TITLE = 12;

    const DECLINE_ORDER_MESSAGE_TITLE = 13;

    const MAKE_ORDER_MESSAGE_TITLE = 14;

    const DELIVERING_ORDER_MESSAGE_TITLE = 15;

    const CANCEL_ORDER_MESSAGE_TITLE = 16;

    const FAILED_ORDER_MESSAGE_TITLE = 17;

    const SUCCESSFUL_ORDER_MESSAGE_TITLE = 18;

    const OTP_MESSAGE = 19;

    const THANKS_MESSAGE = 20;

    const ASSIGNED_ORDER_MESSAGE_AGENT = 21;

    const FAILED_MESSAGE = 22;

    const ASSOCIATION_EXPENSES_REQUESTED_MESSAGE = 23;

    const ASSOCIATION_EXPENSES_REQUESTED_TITLE = 24;

    const INVOICE_MESSAGE = 25;

    const CANCEL_MESSAGE = 26;
}
