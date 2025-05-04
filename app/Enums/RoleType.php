<?php

namespace App\Enums;


use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

/**
 * @method static static SUPER_ADMIN()
 * @method static static ADMIN()
 * @method static static EDITOR()
 */
final class RoleType extends Enum
{
    const SUPER_ADMIN = 'SUPER_ADMIN';

    const ADMIN = 'ADMIN';

    const EDITOR = 'EDITOR';

    public static function getDescription($value): string
    {
        return Str::headline($value);
    }
}
