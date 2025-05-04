<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogDetailsController;
use App\Http\Controllers\CharitiesDashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DynamicController;
use App\Http\Controllers\EventDetailsController;
use App\Http\Controllers\NewsDetailsController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web     routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => '/{locationSetting?}'], function () {

    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::get('/orders', [DashboardController::class, 'orders']);
        Route::get('/orders-client/pagination', [DashboardController::class, 'fetch_orders']);
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [DashboardController::class, 'updateProfile']);
        Route::get('/points', [DashboardController::class, 'points'])->name('points');
        Route::get('/points-client/pagination', [DashboardController::class, 'fetch_points']);
        Route::get('addresses', [AddressController::class, 'address']);
        Route::post('addresses', [AddressController::class, 'addAddress']);
        Route::get('addresses/{address}', [AddressController::class, 'editAddress']);
        Route::post('addresses/{address}', [AddressController::class, 'updateAddress'])->name('site-update');
    });

    Route::group(['prefix' => 'association'], function () {
        Route::get('/', [CharitiesDashboardController::class, 'index']);
        Route::get('/orders', [CharitiesDashboardController::class, 'orders']);
        Route::post('/orders-association/pagination', [CharitiesDashboardController::class, 'fetch_orders']);
        Route::get('/containers', [CharitiesDashboardController::class, 'containers']);
        Route::post('/containers-association/pagination', [CharitiesDashboardController::class, 'fetch_containers']);
        Route::get('/containers-details', [CharitiesDashboardController::class, 'containersDetails']);
        Route::post('/containers-details/pagination', [CharitiesDashboardController::class, 'fetchContainersDetails']);
        Route::get('/expense', [CharitiesDashboardController::class, 'expense']);
        Route::get('/payments-record', [CharitiesDashboardController::class, 'expense']);
        Route::get('/expenses-association/pagination', [CharitiesDashboardController::class, 'fetch_expense']);
        Route::get('/add-expense', [CharitiesDashboardController::class, 'addExpense']);
        Route::get('/chart-bar', [CharitiesDashboardController::class, 'chartBar']);
        Route::get('/chart-line', [CharitiesDashboardController::class, 'chartLine']);
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::get('login', [LoginController::class, 'login'])->name('login');
        Route::get('logout', [LogoutController::class, 'logout']);
        Route::post('validate-login', [LoginController::class, 'ValidateLogin']);
        Route::post('validate-otp', [LoginController::class, 'ValidateOtp']);
        Route::get('register', [RegisterController::class, 'register'])->name('register');
        Route::post('validate-register', [RegisterController::class, 'ValidateRegister']);
        Route::post('validate-register', [RegisterController::class, 'ValidateRegister']);
        Route::post('otp-dialog', [LoginController::class, 'ShowOtpDialog']);
    });

    Route::post('/contact', [ContactController::class, 'sendContactUs'])->name('sendContactUs');
    Route::get('/thank-you', [OrderController::class, 'thankYouPage']);
    Route::post('make-order', [OrderController::class, 'makeOrder']);
    Route::post('make-order-home', [OrderController::class, 'makeOrderHome']);


    Route::get('/{page?}', [DynamicController::class, 'BaseRoute']);
    Route::get('/language/{language?}', [DynamicController::class, 'changeLanguage']);
    Route::get('/country/{country?}', [DynamicController::class, 'changeCountry']);
    Route::get('/events/{event}', [EventDetailsController::class, 'eventDetails']);
    Route::get('/news/{news}', [NewsDetailsController::class, 'newsDetails']);
    Route::get('/blogs/{blog}', [BlogDetailsController::class, 'blogDetails']);
});

