<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static UNPAID()
 * @method static static PAID()
 */
class PaymentStatus extends Enum
{
    const UNPAID = 1;

    const PAID = 2;
}
