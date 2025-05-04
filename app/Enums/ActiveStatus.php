<?php

namespace App\Enums;


use BenSampo\Enum\Enum;

/**
 * @method static static ACTIVE()
 * @method static static INACTIVE()
 */
final class ActiveStatus extends Enum
{
    const ACTIVE = 1;

    const INACTIVE = 2;
}
