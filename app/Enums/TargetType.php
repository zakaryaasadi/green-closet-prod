<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static SELF()
 * @method static static BLANK()
 */
class TargetType extends Enum
{
    const SELF = '_self';

    const BLANK = '_blank';
}
