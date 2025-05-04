<?php

namespace App\Enums;


use BenSampo\Enum\Enum;

final class IpStatus extends Enum
{
    const ACTIVE = 1;

    const BLOCKED = 2;
}
