<?php

namespace App\Enums;

use BenSampo\Enum\FlaggedEnum;

/**
 * @method static static ORDER_MANAGER()
 * @method static static NEWS_MANAGER()
 * @method static static EVENT_MANAGER()
 * @method static static WEBSITE_MANAGER()
 * @method static static AGENT_DRIVER()
 * @method static static None()
 * @method static static ReadOrders()
 * @method static static WriteOrders()
 * @method static static EditOrders()
 * @method static static DeleteOrders()
 * @method static static ReadNews()
 * @method static static WriteNews()
 * @method static static EditNews()
 * @method static static DeleteNews()
 * @method static static ReadEvents()
 * @method static static WriteEvents()
 * @method static static EditEvents()
 * @method static static DeleteEvents()
 * @method static static ReadSections()
 * @method static static WriteSections()
 * @method static static EditSections()
 * @method static static DeleteSections()
 */
class AccessLevel extends FlaggedEnum
{
    //ORDERS
    const ORDER_MANAGER = 1;

    //NEWS
    const NEWS_MANAGER = 2;

    //EVENTS
    const EVENT_MANAGER = 3;

    //WEBSITE
    const WEBSITE_MANAGER = 4;

    //DRIVER
    const AGENT_DRIVER = 6;
}
