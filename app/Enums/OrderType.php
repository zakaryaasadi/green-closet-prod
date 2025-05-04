<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static DONATION()
 * @method static static RECYCLING()
 */
class OrderType extends Enum
{
    const DONATION = 1;

    const RECYCLING = 2;
}
