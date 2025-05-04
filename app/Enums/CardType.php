<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PARTNER()
 * @method static static ASSOCIATION()
 * @method static static DONATIONS()
 * @method static static RYCICLING()
 * @method static static DONATIONS_ITEMS()
 * @method static static RYCICLING_ITEMS()
 * @method static static OTHERS()
 */
class CardType extends Enum
{
    const PARTNER = 1;

    const ASSOCIATION = 2;

    const DONATIONS = 3;

    const RYCICLING = 4;

    const DONATIONS_ITEMS = 5;

    const RYCICLING_ITEMS = 6;

    const OTHERS = 7;
}
