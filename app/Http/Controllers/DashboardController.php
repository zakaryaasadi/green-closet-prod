<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PointStatus;
use App\Helpers\AppHelper;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Language;
use App\Models\LocationSettings;
use App\Models\User;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use ipinfo\ipinfo\IPinfoException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class DashboardController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth.web', 'isClient']);
    }

    /**
     * Show the application dashboard.
     */
    public function index(LocationSettings $locationSetting = null)
    {
        $user = \Auth::user();
        $clientCountry = AppHelper::getLocationSettings()->country_id;
        //POINTS
        $pointsTotal = $user->points()->where('country_id', '=', $clientCountry)->sum('count');
        $level = (int)($pointsTotal / 500) + 1;
        $userPoints = $user->points()->where('country_id', '=', $clientCountry);
        $points = [
            'all' => $pointsTotal,
            'used' => $userPoints->clone()->where('used', '=', true)->sum('count'),
            'unused' => $userPoints->clone()->where('used', '=', false)->sum('count'),
            'active' => $userPoints->clone()->where('status', '=', PointStatus::ACTIVE)->count(),
            'finish' => $userPoints->clone()->where('status', '=', PointStatus::FINISH)->count(),
            'level' => $level,
            'remain' => (500 * $level) - $pointsTotal,
        ];
        //ORDERS
        $lastOrders = $user->orders()->where('country_id', '=', $clientCountry)->orderByDesc('created_at')->paginate(5);
        $userOrder = $user->orders()->where('country_id', '=', $clientCountry);
        $orders = [
            'lastOrders' => $lastOrders,
            'total' => $userOrder->clone()->count(),
            'created' => $userOrder->clone()->where('status', '=', OrderStatus::CREATED)->count(),
            'assigned' => $userOrder->clone()->where('status', '=', OrderStatus::ASSIGNED)->count(),
            'accepted' => $userOrder->clone()->where('status', '=', OrderStatus::ACCEPTED)->count(),
            'declined' => $userOrder->clone()->where('status', '=', OrderStatus::DECLINE)->count(),
            'delivering' => $userOrder->clone()->where('status', '=', OrderStatus::DELIVERING)->count(),
            'canceled' => $userOrder->clone()->where('status', '=', OrderStatus::CANCEL)->count(),
            'failed' => $userOrder->clone()->where('status', '=', OrderStatus::FAILED)->count(),
            'successful' => $userOrder->clone()->where('status', '=', OrderStatus::SUCCESSFUL)->count(),
            'postponed' => $userOrder->clone()->where('status', '=', OrderStatus::POSTPONED)->count(),
        ];

        //LANGUAGES
        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }

        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSetting);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);

        return view('auth.dashboard', [
            'user' => request()->user(),
            'points' => $points,
            'orders' => $orders,
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
        ]);
    }

    /**
     * @throws IPinfoException
     */
    public function orders(LocationSettings $locationSetting = null)
    {
        $user = \Auth::user();
        $clientCountry = AppHelper::getLocationSettings()->country_id;
        $orders = $user->orders()->where('country_id', '=', $clientCountry)->orderByDesc('created_at');
        $allOrders = $orders->simplePaginate(10);
        $userOrdersCounts = $user->orders()->where('country_id', '=', $clientCountry)->count();
        $languages = Language::all();

        if (request()->has('filter') && request()->input('filter') != 'All') {
            if (request()->input('filter') == 'Created')
                $allOrders = $orders->where('status', '=', OrderStatus::CREATED)->paginate(10);
            elseif (request()->input('filter') == 'Assigned')
                $allOrders = $orders->where('status', '=', OrderStatus::ASSIGNED)->paginate(10);
            elseif (request()->input('filter') == 'Accepted')
                $allOrders = $orders->where('status', '=', OrderStatus::ACCEPTED)->paginate(10);
            elseif (request()->input('filter') == 'Declined')
                $allOrders = $orders->where('status', '=', OrderStatus::DECLINE)->paginate(10);
            elseif (request()->input('filter') == 'Canceled')
                $allOrders = $orders->where('status', '=', OrderStatus::CANCEL)->paginate(10);
            elseif (request()->input('filter') == 'Delivering')
                $allOrders = $orders->where('status', '=', OrderStatus::DELIVERING)->paginate(10);
            elseif (request()->input('filter') == 'Failed')
                $allOrders = $orders->where('status', '=', OrderStatus::FAILED)->paginate(10);
            elseif (request()->input('filter') == 'Successful')
                $allOrders = $orders->where('status', '=', OrderStatus::SUCCESSFUL)->paginate(10);
            elseif (request()->input('filter') == 'Postponed')
                $allOrders = $orders->where('status', '=', OrderStatus::POSTPONED)->paginate(10);
        }
        elseif (request()->has('filter') && request()->input('filter') == 'All') {
            $allOrders = $orders->paginate(10);
        }

        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }
        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSetting);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);

        return view('auth.orders', [
            'user' => request()->user(),
            'orders' => $allOrders,
            'ordersCounts' => $userOrdersCounts,
            'locationSettings' => $locationSetting['structure'],
            'pagination' => $allOrders,
            'languages' => $allLanguages,
        ]);
    }

    /**
     * @throws IPinfoException
     */
    public function fetch_orders(LocationSettings $locationSetting = null)
    {
        if (request()->ajax()) {
            $user = \Auth::user();
            $clientCountry = AppHelper::getLocationSettings()->country_id;
            $orders = $user->orders()->where('country_id', '=', $clientCountry)->orderByDesc('created_at');
            $allOrders = $orders->simplePaginate(10);
            $userOrdersCounts = $user->orders()->where('country_id', '=', $clientCountry)->count();
            $languages = Language::all();
            if (request()->has('filter') && request()->input('filter') != 'All') {
                if (request()->input('filter') == 'Created')
                    $allOrders = $orders->where('status', '=', OrderStatus::CREATED)->paginate(10);
                elseif (request()->input('filter') == 'Assigned')
                    $allOrders = $orders->where('status', '=', OrderStatus::ASSIGNED)->paginate(10);
                elseif (request()->input('filter') == 'Accepted')
                    $allOrders = $orders->where('status', '=', OrderStatus::ACCEPTED)->paginate(10);
                elseif (request()->input('filter') == 'Declined')
                    $allOrders = $orders->where('status', '=', OrderStatus::DECLINE)->paginate(10);
                elseif (request()->input('filter') == 'Canceled')
                    $allOrders = $orders->where('status', '=', OrderStatus::CANCEL)->paginate(10);
                elseif (request()->input('filter') == 'Delivering')
                    $allOrders = $orders->where('status', '=', OrderStatus::DELIVERING)->paginate(10);
                elseif (request()->input('filter') == 'Failed')
                    $allOrders = $orders->where('status', '=', OrderStatus::FAILED)->paginate(10);
                elseif (request()->input('filter') == 'Successful')
                    $allOrders = $orders->where('status', '=', OrderStatus::SUCCESSFUL)->paginate(10);
                elseif (request()->input('filter') == 'Postponed')
                    $allOrders = $orders->where('status', '=', OrderStatus::POSTPONED)->paginate(10);
            } elseif (request()->has('filter') && request()->input('filter') == 'All') {
                $allOrders = $orders->paginate(10);
            }
            foreach ($languages as $language) {
                $allLanguages[] = $language->languageToComponent();
            }
            $uri = $_SERVER['REQUEST_URI'];
            AppHelper::setSection($uri, $locationSetting);
            app()->setLocale($locationSetting->language->code);

            return view('auth.components.orders-client-table', [
                'user' => request()->user(),
                'orders' => $allOrders,
                'ordersCounts' => $userOrdersCounts,
                'locationSettings' => $locationSetting['structure'],
                'pagination' => $allOrders,
                'languages' => $allLanguages,
                'next' => $allOrders->nextPageUrl(),
                'current' => $allOrders->currentPage(),
                'previous' => $allOrders->previousPageUrl(),
            ])->render();

        }
    }

    /**
     * @param LocationSettings|null $locationSetting
     * @return Application|Factory|View
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function profile(LocationSettings $locationSetting = null)
    {
        $country = $locationSetting->country;
        $clientCountry = $country->id;
        $user = \Auth::user();
        $addresses = \Auth::user()->addresses()->where('country_id', '=', $clientCountry)->latest()->get();
        $pointsTotal = $user->points()->where('country_id', '=', $clientCountry)->sum('count');
        $level = (int)($pointsTotal / 500) + 1;
        $userPoints = $user->points()->where('country_id', '=', $clientCountry);
        $points = [
            'all' => $pointsTotal,
            'used' => $userPoints->where('used', '=', true)->sum('count'),
            'unused' => $userPoints->where('used', '=', false)->sum('count'),
            'active' => $userPoints->where('status', '=', PointStatus::ACTIVE)->count(),
            'finish' => $userPoints->where('status', '=', PointStatus::FINISH)->count(),
            'level' => $level,
            'remain' => (500 * $level) - $pointsTotal,

        ];
        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }
        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSetting);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);

        session()->put('getFrom', 'profile');

        return view('auth.profile', [
            'locationSettings' => $locationSetting['structure'],
            'user' => request()->user(),
            'points' => $points,
            'addresses' => $addresses,
            'languages' => $allLanguages,
            'country' => $country,
        ]);
    }

    public function points(LocationSettings $locationSetting = null)
    {
        $clientCountry = AppHelper::getLocationSettings()->country_id;
        $user = \Auth::user();
        $userPointsCounts = $user->points()->where('country_id', '=', $clientCountry)->sum('count');

        $points = $user->points()->where('country_id', '=', $clientCountry)->orderBy('status')->orderBy('ends_at')->paginate(10);

        if (request()->has('filter') && request()->input('filter') != 'All') {
            if (request()->input('filter') == 'Active')
                $points = $user->points()->where('country_id', '=', $clientCountry)->where('status', '=', PointStatus::ACTIVE)->orderBy('ends_at')->paginate(10);
            else
                $points = $user->points()->where('country_id', '=', $clientCountry)->where('status', '=', PointStatus::FINISH)->orderBy('ends_at')->paginate(10);
        } elseif (request()->has('filter') && request()->input('filter') == 'All') {
            $points = $user->points()->paginate(10);
        }

        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }
        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSetting);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);

        return view('auth.points', [
            'user' => request()->user(),
            'points' => $points,
            'userPointsCounts' => $userPointsCounts,
            'locationSettings' => $locationSetting['structure'],
            'pagination' => $points,
            'languages' => $allLanguages,
        ]);
    }

    public function fetch_points(LocationSettings $locationSetting = null)
    {
        if (request()->ajax())
        {
            $user = \Auth::user();
            $clientCountry = AppHelper::getLocationSettings()->country_id;
            $userPointsCounts = $user->points()->where('country_id', '=', $clientCountry)->sum('count');
            $points = $user->points()->where('country_id', '=', $clientCountry)->orderBy('status')->orderBy('ends_at')->paginate(10);

            if (request()->has('filter') && request()->input('filter') != 'All') {
                if (request()->input('filter') == 'Active')
                    $points = $user->points()->where('country_id', '=', $clientCountry)->where('status', '=', PointStatus::ACTIVE)->orderBy('ends_at')->paginate(10);
                else
                    $points = $user->points()->where('country_id', '=', $clientCountry)->where('status', '=', PointStatus::FINISH)->orderBy('ends_at')->paginate(10);
            } elseif (request()->has('filter') && request()->input('filter') == 'All') {
                $points = $user->points()->where('country_id', '=', $clientCountry)->paginate(10);
            }
            $languages = Language::all();
            foreach ($languages as $language) {
                $allLanguages[] = $language->languageToComponent();
            }
            $uri = $_SERVER['REQUEST_URI'];
            AppHelper::setSection($uri, $locationSetting);
            app()->setLocale($locationSetting->language->code);

            return view('auth.components.points-client-table', [
                'user' => request()->user(),
                'points' => $points,
                'userPointsCounts' => $userPointsCounts,
                'locationSettings' => $locationSetting['structure'],
                'languages' => $allLanguages,
            ])->render();
        }

    }

    public function updateProfile(UpdateProfileRequest $request, LocationSettings $locationSetting = null)
    {
        $user = Auth::user();
        $data = collect($request->validated());
        if($data->has('name')) {
            $user->name = $data->get('name');
            $user->save();
        }
        if($data->has('phone')) {
            if (User::wherePhone($data->get('phone'))->first()) {
                return response(['error' => true, 'error-msg' => 'phone already exists'], 422);
            }
            $user->phone = $data->get('phone');
            $user->phone_verified_at = null;
            $user->save();
            Auth::logout();

            return response(['error' => false, 'link' => '/' . AppHelper::getSlug() . '/auth/login'], 200);
        }

        return response(['error' => false, 'link' => '/' . AppHelper::getSlug() . '/dashboard/profile'], 302);
    }
}
