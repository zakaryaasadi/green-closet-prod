<?php

namespace App\Enums;


use BenSampo\Enum\Enum;

/**
 * @method static static PERCENT()
 * @method static static FIXED()
 */
final class OfferType extends Enum
{
    const PERCENT = 1;

    const FIXED = 2;
}
