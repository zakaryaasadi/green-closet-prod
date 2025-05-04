<?php

namespace App\Enums;


use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

/**
 * @method static static AR()
 * @method static static EN()
 */
final class LanguageEnum extends Enum
{
    const AR = 1;

    const EN = 2;

    public static function getDescription($value): string
    {
        return Str::headline($value);
    }
}
