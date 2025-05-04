<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PROCESSING()
 * @method static static PAYED()
 */
class ExpenseStatus extends Enum
{
    const PROCESSING = 1;

    const PAYED = 2;
}
