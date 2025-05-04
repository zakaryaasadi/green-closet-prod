<?php

namespace App\Enums;


use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

/**
 * @method static static ENABLE()
 * @method static static DISABLE()
 */
final class UserStatus extends Enum
{
    const ENABLE = 1;

    const DISABLE = 2;

    public static function getDescription($value): string
    {
        return Str::headline($value);
    }
}
