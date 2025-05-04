<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ON_THE_FIELD()
 * @method static static HANGING()
 * @method static static IN_THE_WAREHOUSE()
 * @method static static IN_MAINTENANCE()
 * @method static static SCRAP()
 */
/**
 * @method static static ON_THE_FIELD()
 * @method static static HANGING()
 * @method static static IN_THE_WAREHOUSE()
 * @method static static IN_MAINTENANCE()
 * @method static static SCRAP()
 */
class ContainerStatus extends Enum
{
    const ON_THE_FIELD = 1;

    const HANGING = 2;

    const IN_THE_WAREHOUSE = 3;

    const IN_MAINTENANCE = 4;

    const SCRAP = 5;
}
