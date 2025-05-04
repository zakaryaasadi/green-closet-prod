<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Helpers\AppHelper;
use App\Models\Language;
use App\Models\LocationSettings;
use Illuminate\Routing\Controller as BaseController;

class ordersClientTableController extends BaseController
{
    public function orders(LocationSettings $locationSetting = null)
    {
        if (request()->ajax()) {
            $user = \Auth::user();
            $orders = $user->orders()->orderByDesc('created_at');
            $allOrders = $orders->simplePaginate(10);
            $userOrdersCounts = $user->orders->count();
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
}
