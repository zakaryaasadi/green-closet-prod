<?php

use App\Http\API\V1\Controllers\Activity\ActivityController;
use App\Http\API\V1\Controllers\Address\AddressController;
use App\Http\API\V1\Controllers\Analytics\AnalyticsController;
use App\Http\API\V1\Controllers\Association\AssociationController;
use App\Http\API\V1\Controllers\Auth\AuthController;
use App\Http\API\V1\Controllers\Blog\BlogController;
use App\Http\API\V1\Controllers\Container\ContainerController;
use App\Http\API\V1\Controllers\Country\CountryController;
use App\Http\API\V1\Controllers\District\DistrictController;
use App\Http\API\V1\Controllers\Event\EventController;
use App\Http\API\V1\Controllers\Expense\ExpenseController;
use App\Http\API\V1\Controllers\IP\IPController;
use App\Http\API\V1\Controllers\Item\ItemController;
use App\Http\API\V1\Controllers\Language\LanguageController;
use App\Http\API\V1\Controllers\Location\LocationController;
use App\Http\API\V1\Controllers\LocationSettings\LocationSettingsController;
use App\Http\API\V1\Controllers\MediaModel\MediaModelController;
use App\Http\API\V1\Controllers\Message\MessageController;
use App\Http\API\V1\Controllers\Neighborhood\NeighborhoodController;
use App\Http\API\V1\Controllers\News\NewsController;
use App\Http\API\V1\Controllers\Offer\OfferController;
use App\Http\API\V1\Controllers\Order\OrderController;
use App\Http\API\V1\Controllers\Page\PageController;
use App\Http\API\V1\Controllers\Partner\PartnerController;
use App\Http\API\V1\Controllers\Permission\PermissionController;
use App\Http\API\V1\Controllers\Point\PointController;
use App\Http\API\V1\Controllers\Province\ProvinceController;
use App\Http\API\V1\Controllers\Role\RoleController;
use App\Http\API\V1\Controllers\Section\SectionController;
use App\Http\API\V1\Controllers\Setting\SettingController;
use App\Http\API\V1\Controllers\Street\StreetController;
use App\Http\API\V1\Controllers\Target\TargetController;
use App\Http\API\V1\Controllers\Team\TeamController;
use App\Http\API\V1\Controllers\User\UserController;
use App\Http\API\V1\Controllers\UserAccess\UserAccessController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::controller(AuthController::class)->group(function () {
            Route::post('register', 'register');
            Route::post('login', 'login');
            Route::post('agent-login', 'agentLogin')->name('agentLogin');
            Route::post('client-login', 'clientLogin')->name('clientLogin');
            Route::post('verify-phone', 'verifyPhone')->name('verifyPhone');
            Route::post('request-forget-password', 'requestForgetPassword');
            Route::post('request-otp', 'requestOTP');
            Route::post('forget-password', 'forgetPassword');
            Route::delete('delete-account', 'deleteAccount');
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::controller(AuthController::class)->group(function () {
                Route::put('update', 'update');
                Route::get('logout', 'logout')->name('token.logout');
                Route::post('change-password', 'changePassword');
                Route::get('refresh', 'refresh')->name('token.refresh');
            });
        });
    });

    Route::get('profile', [UserController::class, 'profile']);
    Route::post('third-party', [OrderController::class, 'makeOrderAsThirdParty']);
    Route::post('third-party-whatsapp', [OrderController::class, 'makeOrderWhatsapp']);
    Route::post('third-party-pos', [OrderController::class, 'makeOrderPOS']);

    Route::middleware('languageMiddleware')->prefix('admin')->group(function () {
        Route::apiResources([
            'roles' => RoleController::class,
            'users' => UserController::class,
            'orders' => OrderController::class,
            'countries' => CountryController::class,
            'provinces' => ProvinceController::class,
            'districts' => DistrictController::class,
            'neighborhoods' => NeighborhoodController::class,
            'streets' => StreetController::class,
            'locations' => LocationController::class,
            'addresses' => AddressController::class,
            'associations' => AssociationController::class,
            'news' => NewsController::class,
            'blogs' => BlogController::class,
            'partners' => PartnerController::class,
            'targets' => TargetController::class,
            'permissions' => PermissionController::class,
            'activities' => ActivityController::class,
            'messages' => MessageController::class,
            'points' => PointController::class,
            'expenses' => ExpenseController::class,
            'settings' => SettingController::class,
            'offers' => OfferController::class,
            'sections' => SectionController::class,
            'containers' => ContainerController::class,
            'events' => EventController::class,
            'teams' => TeamController::class,
            'items' => ItemController::class,
            'media-model' => MediaModelController::class,
            'user-access' => UserAccessController::class,
            'ips' => IPController::class,
        ]);

        Route::get('association-expenses/{association}', [ExpenseController::class, 'getAssociationExpenses']);

        Route::post('analytics-orders-status', [AnalyticsController::class, 'analyticsOrdersStatus']);
        Route::post('failed-orders-report', [AnalyticsController::class, 'failedOrdersReport']);
        Route::post('analytics-containers-status', [AnalyticsController::class, 'analyticsContainersStatus']);
        Route::post('analytics-containers-type', [AnalyticsController::class, 'analyticsContainersType']);
        Route::post('analytics-containers-not-visited', [AnalyticsController::class, 'analyticsContainersNotVisited']);
        Route::post('analytics-associations-containers', [AnalyticsController::class, 'numberOfContainersForEachAssociation']);
        Route::post('analytics-container-weights', [AnalyticsController::class, 'analyticsContainerWeights']);
        Route::post('analytics-weights-containers-for-teams', [AnalyticsController::class, 'weightsOfContainersForEachTeam']);
        Route::post('analytics-weights-orders-for-items', [AnalyticsController::class, 'weightOfOrdersForItems']);
        Route::post('analytics-weights-orders-for-teams', [AnalyticsController::class, 'weightOfOrdersForTeams']);
        Route::post('analytics-number-orders-for-items', [AnalyticsController::class, 'numberOfOrdersForItems']);
        Route::post('analytics-containers-details', [AnalyticsController::class, 'analyticsContainersDetails']);
        Route::post('analytics-containers-unloading', [AnalyticsController::class, 'analyticsContainersUnloading']);
        Route::post('analytics-agents', [AnalyticsController::class, 'analyticsAgents']);
        Route::post('analytics', [AnalyticsController::class, 'analytics']);

        Route::post('daily-report', [AnalyticsController::class, 'dailyReport']);
        Route::post('daily-report-containers', [AnalyticsController::class, 'dailyReportContainers']);
        Route::post('daily-report-orders', [AnalyticsController::class, 'dailyReportOrders']);
        Route::post('best-containers', [AnalyticsController::class, 'bestContainers']);
        Route::post('daily-containers-count', [AnalyticsController::class, 'dailyReportContainersCount']);
        Route::post('daily-agents-report', [AnalyticsController::class, 'dailyAgentsReport']);
        Route::post('countries-report', [AnalyticsController::class, 'countriesReport']);
        Route::post('provinces-report', [AnalyticsController::class, 'provincesReport']);
        Route::post('users-report', [AnalyticsController::class, 'usersReport']);
        Route::post('associations-report', [AnalyticsController::class, 'associationsReport']);


        Route::post('locations-report', [AnalyticsController::class, 'getLocationsReport']);

        Route::get('orders-report-pdf', [OrderController::class, 'getPdfReport']);
        Route::get('orders-report-excel', [OrderController::class, 'exportExcel']);
        Route::put('orders/{order}/update-items', [OrderController::class, 'updateOrderItems']);


        Route::get('containers-report-pdf', [ContainerController::class, 'getPdfReport']);
        Route::get('containers-report-excel', [ContainerController::class, 'exportExcel']);

        Route::get('containers/{container}/details', [ContainerController::class, 'getContainerDetails']);


        Route::post('containers-details/', [ContainerController::class, 'storeContainerDetailsByAdmin']);

        Route::put('containers-details/{containerDetails}/update', [ContainerController::class, 'updateContainerDetails']);


        Route::get('location-settings', [LocationSettingsController::class, 'index']);
        Route::post('location-settings', [LocationSettingsController::class, 'store']);
        Route::get('location-settings/{location_setting:id}', [LocationSettingsController::class, 'show']);
        Route::put('location-settings/{location_setting:id}', [LocationSettingsController::class, 'update']);
        Route::delete('location-settings/{location_setting:id}', [LocationSettingsController::class, 'destroy']);


        Route::get('pages', [PageController::class, 'index']);
        Route::post('pages', [PageController::class, 'store']);
        Route::get('pages/{page:id}', [PageController::class, 'show']);
        Route::put('pages/{page:id}', [PageController::class, 'update']);
        Route::delete('pages/{page:id}', [PageController::class, 'destroy']);

        Route::get('languages', [LanguageController::class, 'index']);
        Route::post('languages', [LanguageController::class, 'store']);
        Route::get('languages/{language:id}', [LanguageController::class, 'show']);
        Route::put('languages/{language:id}', [LanguageController::class, 'update']);
        Route::delete('languages/{language:id}', [LanguageController::class, 'destroy']);

        Route::get('order-history/{order}', [ActivityController::class, 'getOrderLog']);
        Route::get('container-history/{container}', [ActivityController::class, 'getContainerLog']);


        Route::get('order-invoice/{order}', [OrderController::class, 'generateInvoice']);

        Route::post('agents/settings', [UserController::class, 'updateAgentSettings']);
        Route::post('teams/{order}/by-geo', [TeamController::class, 'getTeamByGeo']);

        Route::controller(OrderController::class)->prefix('orders')->group(function () {
            Route::post('{order}/status/assigned', 'makeOrderAssigned');
            Route::post('delete-many', 'deleteManyOrders');
            Route::post('update-many', 'updateManyOrders');
        });

        Route::controller(AssociationController::class)->prefix('associations')->group(function () {
            Route::post('{association}/images/upload', 'uploadImages');
            Route::post('{association}/images/delete', 'deleteImages');
        });

        Route::controller(EventController::class)->prefix('events')->group(function () {
            Route::post('{event}/images/upload', 'uploadImages');
            Route::post('{event}/images/delete', 'deleteImages');
        });

        Route::controller(NewsController::class)->prefix('news')->group(function () {
            Route::post('{news}/images/upload', 'uploadImages');
            Route::post('{news}/images/delete', 'deleteImages');
        });


        Route::prefix('users')->group(function () {
            Route::post('{user}/roles', [UserController::class, 'storeRoles']);
            Route::get('{user}/roles', [UserController::class, 'indexRoles']);
        });

        Route::prefix('roles')->group(function () {
            Route::get('{role}/permissions', [RoleController::class, 'indexPermissions']);
            Route::post('{role}/permissions', [RoleController::class, 'storePermissions']);
        });


    });

    Route::middleware('languageMiddleware')->prefix('customer')->group(function () {
        Route::put('update-profile', [AuthController::class, 'updateProfile']);
        Route::get('addresses', [AddressController::class, 'indexUserAddress']);
        Route::get('provinces', [ProvinceController::class, 'getProvincesForClient']);
        Route::get('countries', [CountryController::class, 'getCountriesForClient']);
        Route::get('countries/{country}', [CountryController::class, 'showCountryForClient']);
        Route::get('addresses/{address}', [AddressController::class, 'showUserAddress']);
        Route::post('addresses', [AddressController::class, 'storeUserAddress']);
        Route::put('addresses/{address}', [AddressController::class, 'updateUserAddress']);
        Route::delete('addresses/{address}', [AddressController::class, 'deleteUserAddress']);

        Route::put('update-country', [UserController::class, 'updateUserCountry']);

        Route::post('orders', [OrderController::class, 'storeCustomerOrder']);
        Route::post('make-order', [OrderController::class, 'storeOrderEasyWay']);
        Route::get('orders', [OrderController::class, 'indexCustomerOrder']);
        Route::get('orders/{order}', [OrderController::class, 'showCustomerOrder']);

        Route::post('home-page', [PageController::class, 'homePage']);
        Route::post('send-mail', [PageController::class, 'sendMail']);
        Route::get('how-we-work-page', [PageController::class, 'howWeWork']);

        Route::get('thanks-message', [MessageController::class, 'getThanksMessage']);

        Route::get('events', [EventController::class, 'indexCustomerEvent']);
        Route::get('events/{event}', [EventController::class, 'showCustomerEvent']);

        Route::get('offers', [OfferController::class, 'indexOfferForClient']);


        Route::get('news', [NewsController::class, 'indexCustomerNews']);
        Route::get('news/{news}', [NewsController::class, 'showCustomerNews']);

        Route::get('associations', [AssociationController::class, 'indexCustomerAssociation']);
        Route::get('associations/{association}', [AssociationController::class, 'showCustomerAssociation']);

        Route::get('points', [PointController::class, 'indexCustomerPoints']);
        Route::get('last-point', [PointController::class, 'getLastActivePoint']);

        Route::get('contact-us', [PageController::class, 'contactUs']);

        Route::get('partners', [PartnerController::class, 'indexClientPartners']);
        Route::get('items', [ItemController::class, 'indexClientItem']);
        Route::get('partners/{partner}', [PartnerController::class, 'showClientPartners']);
    });

    Route::group(['prefix' => 'agent'], function () {
        Route::get('orders', [OrderController::class, 'indexAgentOrder']);
        Route::get('order-details/{order}', [OrderController::class, 'showAgentOrder']);
        Route::get('orders-count', [OrderController::class, 'getAgentOrderCount']);
        Route::get('orders/{order}', [OrderController::class, 'showOrderDetails']);
        Route::get('failed-messages', [MessageController::class, 'getFailedMessages']);
        Route::get('cancel-messages', [MessageController::class, 'getCancelMessages']);

        Route::middleware('arabicNumbersMiddleware')->post('orders/{order}/status/postponed', [OrderController::class, 'makeOrderPostponed']);
        Route::post('orders/{order}/status/accept', [OrderController::class, 'makeOrderAccepted']);
        Route::post('orders/{order}/status/decline', [OrderController::class, 'makeOrderDeclined']);
        Route::post('orders/{order}/status/postponed', [OrderController::class, 'makeOrderPostponed']);
        Route::post('orders/{order}/status/cancel', [OrderController::class, 'makeOrderCanceled']);
        Route::post('orders/{order}/status/delivering', [OrderController::class, 'makeOrderDelivering']);
        Route::post('orders/{order}/status/failed', [OrderController::class, 'makeOrderFailed']);
        Route::post('orders/{order}/status/successful', [OrderController::class, 'makeOrderSuccessful']);
        Route::get('near-order', [OrderController::class, 'indexNearbyOrders']);
        Route::get('containers', [ContainerController::class, 'indexAgentContainers']);
        Route::get('containers/{container}', [ContainerController::class, 'showAgentContainer']);
        Route::get('near-container', [ContainerController::class, 'indexNearbyContainers']);
        Route::post('containers', [ContainerController::class, 'storeContainerDetails']);
    });

});
