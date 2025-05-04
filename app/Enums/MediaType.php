<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static IMAGE()
 * @method static static VIDEO()
 */
final class MediaType extends Enum
{
    const IMAGE = 1;

    const VIDEO = 2;
}
