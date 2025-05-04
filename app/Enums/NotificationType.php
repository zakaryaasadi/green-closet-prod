<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OTHER()
 * @method static static ORDER_CREATED()
 * @method static static ORDER_ASSIGNED()
 * @method static static ORDER_ACCEPTED()
 * @method static static ORDER_DECLINE()
 * @method static static ORDER_CANCEL()
 * @method static static ORDER_DELIVERING()
 * @method static static ORDER_FAILED()
 * @method static static ORDER_SUCCESSFUL()
 * @method static static EXPENSE_CREATED()
 */
class NotificationType extends Enum
{
    const OTHER = 0;

    const ORDER_CREATED = 1;

    const ORDER_ASSIGNED = 2;

    const ORDER_ACCEPTED = 3;

    const ORDER_DECLINE = 4;

    const ORDER_CANCEL = 5;

    const ORDER_DELIVERING = 6;

    const ORDER_FAILED = 7;

    const ORDER_SUCCESSFUL = 8;

    const EXPENSE_CREATED = 9;
}
