<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CREATED()
 * @method static static ASSIGNED()
 * @method static static ACCEPTED()
 * @method static static DECLINE()
 * @method static static CANCEL()
 * @method static static DELIVERING()
 * @method static static FAILED()
 * @method static static SUCCESSFUL()
 * @method static static POSTPONED()
 */
final class OrderStatus extends Enum
{
    const CREATED = 1;

    const ASSIGNED = 2;

    const ACCEPTED = 3;

    const DECLINE = 4;

    const CANCEL = 5;

    const DELIVERING = 6;

    const FAILED = 7;

    const SUCCESSFUL = 8;

    const POSTPONED = 9;
}
