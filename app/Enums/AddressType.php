<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static APARTMENT()
 * @method static static VILLA()
 * @method static static HOTEL()
 * @method static static OFFICE()
 * @method static static OTHER()
 */
final class AddressType extends Enum
{
    const APARTMENT = 1;

    const VILLA = 2;

    const HOTEL = 3;

    const OFFICE = 4;

    const OTHER = 5;
}
