<?php

namespace App\Enums;


use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

/**
 * @method static static INDEX_USER()
 * @method static static SHOW_USER()
 * @method static static STORE_USER()
 * @method static static UPDATE_USER()
 * @method static static DELETE_USER()
 * @method static static DASHBOARD_ACCESS()
 * @method static static SHOW_ROLE()
 * @method static static STORE_ROLE()
 * @method static static DELETE_ROLE()
 * @method static static UPDATE_ROLE()
 * @method static static INDEX_ROLE()
 * @method static static EDIT_ROLE_PERMISSION()
 * @method static static SHOW_ROLE_PERMISSION()
 * @method static static SHOW_USER_ROLE()
 * @method static static EDIT_USER_ROLE()
 * @method static static INDEX_AGENTS()
 * @method static static SHOW_PERMISSIONS()
 * @method static static UPDATE_USER_PERMISSIONS()
 * @method static static UPDATE_AGENT_SETTINGS()
 * @method static static INDEX_COUNTRY()
 * @method static static SHOW_COUNTRY()
 * @method static static STORE_COUNTRY()
 * @method static static UPDATE_COUNTRY()
 * @method static static DELETE_COUNTRY()
 * @method static static INDEX_PROVINCE()
 * @method static static SHOW_PROVINCE()
 * @method static static STORE_PROVINCE()
 * @method static static UPDATE_PROVINCE()
 * @method static static DELETE_PROVINCE()
 * @method static static INDEX_DISTRICT()
 * @method static static SHOW_DISTRICT()
 * @method static static STORE_DISTRICT()
 * @method static static UPDATE_DISTRICT()
 * @method static static DELETE_DISTRICT()
 * @method static static INDEX_NEIGHBORHOOD()
 * @method static static SHOW_NEIGHBORHOOD()
 * @method static static STORE_NEIGHBORHOOD()
 * @method static static UPDATE_NEIGHBORHOOD()
 * @method static static DELETE_NEIGHBORHOOD()
 * @method static static INDEX_STREET()
 * @method static static SHOW_STREET()
 * @method static static STORE_STREET()
 * @method static static UPDATE_STREET()
 * @method static static DELETE_STREET()
 * @method static static INDEX_LOCATION()
 * @method static static SHOW_LOCATION()
 * @method static static STORE_LOCATION()
 * @method static static UPDATE_LOCATION()
 * @method static static DELETE_LOCATION()
 * @method static static INDEX_LOCATION_SETTINGS()
 * @method static static SHOW_LOCATION_SETTINGS()
 * @method static static STORE_LOCATION_SETTINGS()
 * @method static static UPDATE_LOCATION_SETTINGS()
 * @method static static DELETE_LOCATION_SETTINGS()
 * @method static static INDEX_OFFER()
 * @method static static SHOW_OFFER()
 * @method static static STORE_OFFER()
 * @method static static UPDATE_OFFER()
 * @method static static DELETE_OFFER()
 * @method static static INDEX_TEAM()
 * @method static static SHOW_TEAM()
 * @method static static STORE_TEAM()
 * @method static static UPDATE_TEAM()
 * @method static static DELETE_TEAM()
 * @method static static INDEX_CONTAINER()
 * @method static static SHOW_CONTAINER()
 * @method static static STORE_CONTAINER()
 * @method static static UPDATE_CONTAINER()
 * @method static static DELETE_CONTAINER()
 * @method static static INDEX_ORDER()
 * @method static static SHOW_ORDER()
 * @method static static STORE_ORDER()
 * @method static static UPDATE_ORDER()
 * @method static static UPDATE_MANY_ORDER()
 * @method static static DELETE_ORDER()
 * @method static static DELETE_MANY_ORDER()
 * @method static static ACCEPT_ORDER()
 * @method static static MAKE_ORDER_ASSIGNED()
 * @method static static CANCEL_ORDER()
 * @method static static COMPLETE_ORDER()
 * @method static static DELIVERING_ORDER()
 * @method static static SOS_ORDER()
 * @method static static INDEX_ADDRESS()
 * @method static static SHOW_ADDRESS()
 * @method static static STORE_ADDRESS()
 * @method static static UPDATE_ADDRESS()
 * @method static static DELETE_ADDRESS()
 * @method static static INDEX_ASSOCIATION()
 * @method static static SHOW_ASSOCIATION()
 * @method static static STORE_ASSOCIATION()
 * @method static static UPDATE_ASSOCIATION()
 * @method static static DELETE_ASSOCIATION()
 * @method static static UPLOAD_ASSOCIATION_IMAGES()
 * @method static static DELETE_ASSOCIATION_IMAGES()
 * @method static static INDEX_NEWS()
 * @method static static SHOW_NEWS()
 * @method static static STORE_NEWS()
 * @method static static UPDATE_NEWS()
 * @method static static DELETE_NEWS()
 * @method static static UPLOAD_NEWS_IMAGES()
 * @method static static DELETE_NEWS_IMAGES()
 * @method static static INDEX_PARTNER()
 * @method static static SHOW_PARTNER()
 * @method static static STORE_PARTNER()
 * @method static static UPDATE_PARTNER()
 * @method static static DELETE_PARTNER()
 * @method static static INDEX_PAGE()
 * @method static static SHOW_PAGE()
 * @method static static STORE_PAGE()
 * @method static static UPDATE_PAGE()
 * @method static static DELETE_PAGE()
 * @method static static ANALYTICS()
 * @method static static INDEX_SECTION()
 * @method static static SHOW_SECTION()
 * @method static static STORE_SECTION()
 * @method static static UPDATE_SECTION()
 * @method static static DELETE_SECTION()
 * @method static static INDEX_LANGUAGE()
 * @method static static SHOW_LANGUAGE()
 * @method static static STORE_LANGUAGE()
 * @method static static UPDATE_LANGUAGE()
 * @method static static DELETE_LANGUAGE()
 * @method static static INDEX_MESSAGE()
 * @method static static SHOW_MESSAGE()
 * @method static static STORE_MESSAGE()
 * @method static static UPDATE_MESSAGE()
 * @method static static DELETE_MESSAGE()
 * @method static static INDEX_SETTING()
 * @method static static SHOW_SETTING()
 * @method static static STORE_SETTING()
 * @method static static UPDATE_SETTING()
 * @method static static DELETE_SETTING()
 * @method static static INDEX_POINT()
 * @method static static SHOW_POINT()
 * @method static static STORE_POINT()
 * @method static static UPDATE_POINT()
 * @method static static DELETE_POINT()
 * @method static static INDEX_ITEM()
 * @method static static SHOW_ITEM()
 * @method static static STORE_ITEM()
 * @method static static UPDATE_ITEM()
 * @method static static DELETE_ITEM()
 * @method static static INDEX_EXPENSE()
 * @method static static SHOW_EXPENSE()
 * @method static static STORE_EXPENSE()
 * @method static static UPDATE_EXPENSE()
 * @method static static DELETE_EXPENSE()
 * @method static static INDEX_ASSOCIATION_EXPENSES()
 * @method static static INDEX_EVENT()
 * @method static static SHOW_EVENT()
 * @method static static STORE_EVENT()
 * @method static static UPDATE_EVENT()
 * @method static static DELETE_EVENT()
 * @method static static UPLOAD_EVENT_IMAGES()
 * @method static static DELETE_EVENT_IMAGES()
 * @method static static INDEX_MEDIA_MODEL()
 * @method static static SHOW_MEDIA_MODEL()
 * @method static static STORE_MEDIA_MODEL()
 * @method static static UPDATE_MEDIA_MODEL()
 * @method static static DELETE_MEDIA_MODEL()
 * @method static static INDEX_USER_ACCESS()
 * @method static static SHOW_USER_ACCESS()
 * @method static static STORE_USER_ACCESS()
 * @method static static UPDATE_USER_ACCESS()
 * @method static static DELETE_USER_ACCESS()
 * @method static static INDEX_ACTIVITY()
 * @method static static SHOW_ACTIVITY()
 * @method static static GET_ORDER_LOG()
 * @method static static GET_CONTAINER_LOG()
 * @method static static INDEX_ORDERS_REPORT()
 * @method static static INDEX_CONTAINERS_REPORT()
 * @method static static INDEX_REPORT()
 * @method static static MAKE_ORDER_ACTIVE()
 * @method static static GET_ASSOCIATION_IMAGES()
 * @method static static GET_NEWS_IMAGES()
 * @method static static GET_EVENT_IMAGES()
 * @method static static INDEX_FAQ()
 * @method static static SHOW_FAQ()
 * @method static static STORE_FAQ()
 * @method static static UPDATE_FAQ()
 * @method static static DELETE_FAQ()
 * @method static static UPLOAD_IMAGE()
 * @method static static GET_IMAGES()
 */
final class PermissionType extends Enum
{
    const INDEX_USER = 'INDEX_USER';

    const SHOW_USER = 'SHOW_USER';

    const MANAGE_CLIENT = 'MANAGE_CLIENT';

    const STORE_USER = 'STORE_USER';

    const UPDATE_USER = 'UPDATE_USER';

    const DELETE_USER = 'DELETE_USER';

    const DASHBOARD_ACCESS = 'DASHBOARD_ACCESS';

    const SHOW_ROLE = 'SHOW_ROLE';

    const STORE_ROLE = 'STORE_ROLE';

    const DELETE_ROLE = 'DELETE_ROLE';

    const UPDATE_ROLE = 'UPDATE_ROLE';

    const INDEX_ROLE = 'INDEX_ROLE';

    const EDIT_ROLE_PERMISSION = 'EDIT_ROLE_PERMISSION';

    const SHOW_ROLE_PERMISSION = 'SHOW_ROLE_PERMISSION';

    const SHOW_USER_ROLE = 'SHOW_USER_ROLE';

    const EDIT_USER_ROLE = 'EDIT_USER_ROLE';

    const INDEX_AGENTS = 'INDEX_AGENTS';

    const SHOW_PERMISSIONS = 'SHOW_PERMISSIONS';

    const UPDATE_USER_PERMISSIONS = 'UPDATE_USER_PERMISSIONS';

    const UPDATE_AGENT_SETTINGS = 'ADD_AGENT_SETTINGS';

    //Country
    const INDEX_COUNTRY = 'INDEX_COUNTRY';

    const SHOW_COUNTRY = 'SHOW_COUNTRY';

    const STORE_COUNTRY = 'STORE_COUNTRY';

    const UPDATE_COUNTRY = 'UPDATE_COUNTRY';

    const DELETE_COUNTRY = 'DELETE_COUNTRY';

    //Province
    const INDEX_PROVINCE = 'INDEX_PROVINCE';

    const SHOW_PROVINCE = 'SHOW_PROVINCE';

    const STORE_PROVINCE = 'STORE_PROVINCE';

    const UPDATE_PROVINCE = 'UPDATE_PROVINCE';

    const DELETE_PROVINCE = 'DELETE_PROVINCE';

    //District
    const INDEX_DISTRICT = 'INDEX_DISTRICT';

    const SHOW_DISTRICT = 'SHOW_DISTRICT';

    const STORE_DISTRICT = 'STORE_DISTRICT';

    const UPDATE_DISTRICT = 'UPDATE_DISTRICT';

    const DELETE_DISTRICT = 'DELETE_DISTRICT';

    //Neighborhood
    const INDEX_NEIGHBORHOOD = 'INDEX_NEIGHBORHOOD';

    const SHOW_NEIGHBORHOOD = 'SHOW_NEIGHBORHOOD';

    const STORE_NEIGHBORHOOD = 'STORE_NEIGHBORHOOD';

    const UPDATE_NEIGHBORHOOD = 'UPDATE_NEIGHBORHOOD';

    const DELETE_NEIGHBORHOOD = 'DELETE_NEIGHBORHOOD';

    //Street
    const INDEX_STREET = 'INDEX_STREET';

    const SHOW_STREET = 'SHOW_STREET';

    const STORE_STREET = 'STORE_STREET';

    const UPDATE_STREET = 'UPDATE_STREET';

    const DELETE_STREET = 'DELETE_STREET';

    //Location
    const INDEX_LOCATION = 'INDEX_LOCATION';

    const SHOW_LOCATION = 'SHOW_LOCATION';

    const STORE_LOCATION = 'STORE_LOCATION';

    const UPDATE_LOCATION = 'UPDATE_LOCATION';

    const DELETE_LOCATION = 'DELETE_LOCATION';

    //Location Setting
    const INDEX_LOCATION_SETTINGS = 'INDEX_LOCATION_SETTINGS';

    const SHOW_LOCATION_SETTINGS = 'SHOW_LOCATION_SETTINGS';

    const STORE_LOCATION_SETTINGS = 'STORE_LOCATION_SETTINGS';

    const UPDATE_LOCATION_SETTINGS = 'UPDATE_LOCATION_SETTINGS';

    const DELETE_LOCATION_SETTINGS = 'DELETE_LOCATION_SETTINGS';

    //Offer
    const INDEX_OFFER = 'INDEX_OFFER';

    const SHOW_OFFER = 'SHOW_OFFER';

    const STORE_OFFER = 'STORE_OFFER';

    const UPDATE_OFFER = 'UPDATE_OFFER';

    const DELETE_OFFER = 'DELETE_OFFER';

    //team
    const INDEX_TEAM = 'INDEX_TEAM';

    const SHOW_TEAM = 'SHOW_TEAM';

    const STORE_TEAM = 'STORE_TEAM';

    const UPDATE_TEAM = 'UPDATE_TEAM';

    const DELETE_TEAM = 'DELETE_TEAM';

    //Container
    const INDEX_CONTAINER = 'INDEX_CONTAINER';

    const SHOW_CONTAINER = 'SHOW_CONTAINER';

    const STORE_CONTAINER = 'STORE_CONTAINER';

    const UPDATE_CONTAINER = 'UPDATE_CONTAINER';

    const DELETE_CONTAINER = 'DELETE_CONTAINER';

    //Order
    const INDEX_ORDER = 'INDEX_ORDER';

    const SHOW_ORDER = 'SHOW_ORDER';

    const STORE_ORDER = 'STORE_ORDER';

    const UPDATE_ORDER = 'UPDATE_ORDER';

    const UPDATE_MANY_ORDER = 'UPDATE_MANY_ORDER';

    const DELETE_ORDER = 'DELETE_ORDER';

    const DELETE_MANY_ORDER = 'DELETE_MANY_ORDER';

    const ACCEPT_ORDER = 'ACCEPT_ORDER';

    const MAKE_ORDER_ASSIGNED = 'MAKE_ORDER_ASSIGNED';

    const CANCEL_ORDER = 'CANCEL_ORDER';

    const COMPLETE_ORDER = 'COMPLETE_ORDER';

    const DELIVERING_ORDER = 'DELIVERING_ORDER';

    const SOS_ORDER = 'SOS_ORDER';

    //Address
    const INDEX_ADDRESS = 'INDEX_ADDRESS';

    const SHOW_ADDRESS = 'SHOW_ADDRESS';

    const STORE_ADDRESS = 'STORE_ADDRESS';

    const UPDATE_ADDRESS = 'UPDATE_ADDRESS';

    const DELETE_ADDRESS = 'DELETE_ADDRESS';

    //Association
    const INDEX_ASSOCIATION = 'INDEX_ASSOCIATION';

    const SHOW_ASSOCIATION = 'SHOW_ASSOCIATION';

    const STORE_ASSOCIATION = 'STORE_ASSOCIATION';

    const UPDATE_ASSOCIATION = 'UPDATE_ASSOCIATION';

    const DELETE_ASSOCIATION = 'DELETE_ASSOCIATION';

    const UPLOAD_ASSOCIATION_IMAGES = 'UPLOAD_ASSOCIATION_IMAGES';

    const DELETE_ASSOCIATION_IMAGES = 'DELETE_ASSOCIATION_IMAGES';

    //News
    const INDEX_NEWS = 'INDEX_NEWS';

    const SHOW_NEWS = 'SHOW_NEWS';

    const STORE_NEWS = 'STORE_NEWS';

    const UPDATE_NEWS = 'UPDATE_NEWS';

    const DELETE_NEWS = 'DELETE_NEWS';

    const UPLOAD_NEWS_IMAGES = 'UPLOAD_NEWS_IMAGES';

    const DELETE_NEWS_IMAGES = 'DELETE_NEWS_IMAGES';

    //Blog
    const INDEX_BLOG = 'INDEX_BLOG';

    const SHOW_BLOG = 'SHOW_BLOG';

    const STORE_BLOG = 'STORE_BLOG';

    const UPDATE_BLOG = 'UPDATE_BLOG';

    const DELETE_BLOG = 'DELETE_BLOG';

    //Partner
    const INDEX_PARTNER = 'INDEX_PARTNER';

    const SHOW_PARTNER = 'SHOW_PARTNER';

    const STORE_PARTNER = 'STORE_PARTNER';

    const UPDATE_PARTNER = 'UPDATE_PARTNER';

    const DELETE_PARTNER = 'DELETE_PARTNER';

    //Page
    const INDEX_PAGE = 'INDEX_PAGE';

    const SHOW_PAGE = 'SHOW_PAGE';

    const STORE_PAGE = 'STORE_PAGE';

    const UPDATE_PAGE = 'UPDATE_PAGE';

    const DELETE_PAGE = 'DELETE_PAGE';

    const ANALYTICS = 'ANALYTICS';

    //Section
    const INDEX_SECTION = 'INDEX_SECTION';

    const SHOW_SECTION = 'SHOW_SECTION';

    const STORE_SECTION = 'STORE_SECTION';

    const UPDATE_SECTION = 'UPDATE_SECTION';

    const DELETE_SECTION = 'DELETE_SECTION';

    //Language
    const INDEX_LANGUAGE = 'INDEX_LANGUAGE';

    const SHOW_LANGUAGE = 'SHOW_LANGUAGE';

    const STORE_LANGUAGE = 'STORE_LANGUAGE';

    const UPDATE_LANGUAGE = 'UPDATE_LANGUAGE';

    const DELETE_LANGUAGE = 'DELETE_LANGUAGE';

    //Message
    const INDEX_MESSAGE = 'INDEX_MESSAGE';

    const SHOW_MESSAGE = 'SHOW_MESSAGE';

    const STORE_MESSAGE = 'STORE_MESSAGE';

    const UPDATE_MESSAGE = 'UPDATE_MESSAGE';

    const DELETE_MESSAGE = 'DELETE_MESSAGE';

    //Setting
    const INDEX_SETTING = 'INDEX_SETTING';

    const SHOW_SETTING = 'SHOW_SETTING';

    const STORE_SETTING = 'STORE_SETTING';

    const UPDATE_SETTING = 'UPDATE_SETTING';

    const DELETE_SETTING = 'DELETE_SETTING';

    //Point
    const INDEX_POINT = 'INDEX_POINT';

    const SHOW_POINT = 'SHOW_POINT';

    const STORE_POINT = 'STORE_POINT';

    const UPDATE_POINT = 'UPDATE_POINT';

    const DELETE_POINT = 'DELETE_POINT';

    //Item
    const INDEX_ITEM = 'INDEX_ITEM';

    const SHOW_ITEM = 'SHOW_ITEM';

    const STORE_ITEM = 'STORE_ITEM';

    const UPDATE_ITEM = 'UPDATE_ITEM';

    const DELETE_ITEM = 'DELETE_ITEM';

    //Expense
    const INDEX_EXPENSE = 'INDEX_EXPENSE';

    const SHOW_EXPENSE = 'SHOW_EXPENSE';

    const STORE_EXPENSE = 'STORE_EXPENSE';

    const UPDATE_EXPENSE = 'UPDATE_EXPENSE';

    const DELETE_EXPENSE = 'DELETE_EXPENSE';

    const INDEX_ASSOCIATION_EXPENSES = 'INDEX_ASSOCIATION_EXPENSES';

    //Event
    const INDEX_EVENT = 'INDEX_EVENT';

    const SHOW_EVENT = 'SHOW_EVENT';

    const STORE_EVENT = 'STORE_EVENT';

    const UPDATE_EVENT = 'UPDATE_EVENT';

    const DELETE_EVENT = 'DELETE_EVENT';

    const UPLOAD_EVENT_IMAGES = 'UPLOAD_EVENT_IMAGES';

    const DELETE_EVENT_IMAGES = 'DELETE_EVENT_IMAGES';

    //Media model
    const INDEX_MEDIA_MODEL = 'INDEX_MEDIA_MODEL';

    const SHOW_MEDIA_MODEL = 'SHOW_MEDIA_MODEL';

    const STORE_MEDIA_MODEL = 'STORE_MEDIA_MODEL';

    const UPDATE_MEDIA_MODEL = 'UPDATE_MEDIA_MODEL';

    const DELETE_MEDIA_MODEL = 'DELETE_MEDIA_MODEL';

    //User Access
    const INDEX_USER_ACCESS = 'INDEX_USER_ACCESS';

    const SHOW_USER_ACCESS = 'SHOW_USER_ACCESS';

    const STORE_USER_ACCESS = 'STORE_USER_ACCESS';

    const UPDATE_USER_ACCESS = 'UPDATE_USER_ACCESS';

    const DELETE_USER_ACCESS = 'DELETE_USER_ACCESS';

    //Activity
    const INDEX_ACTIVITY = 'INDEX_ACTIVITY';

    const SHOW_ACTIVITY = 'SHOW_ACTIVITY';

    const GET_ORDER_LOG = 'GET_ORDER_LOG';

    const GET_CONTAINER_LOG = 'GET_CONTAINER_LOG';

    //Reports
    const INDEX_ORDERS_REPORT = 'INDEX_ORDERS_REPORT';

    const INDEX_CONTAINERS_REPORT = 'INDEX_CONTAINERS_REPORT';

    const INDEX_REPORT = 'INDEX_REPORT';

    public static function getDescription($value): string
    {
        return Str::headline($value);
    }
}
