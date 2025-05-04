<?php

namespace App\Enums;


use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

/**
 * @method static static AGENT()
 * @method static static CLIENT()
 * @method static static ADMIN()
 * @method static static MANAGER()
 * @method static static ASSOCIATION()
 */
final class UserType extends Enum
{
    const AGENT = 1;

    const CLIENT = 2;

    const ADMIN = 3;

    const ASSOCIATION = 4;

    public static function getDescription($value): string
    {
        return Str::headline($value);
    }
}
