<?php

namespace App\Http\Controllers;

use App\Enums\ContainerType;
use App\Enums\ExpenseStatus;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Events\Admin\AssociationExpenseRequestEvent;
use App\Helpers\AppHelper;
use App\Models\Association;
use App\Models\Container;
use App\Models\ContainerDetails;
use App\Models\Expense;
use App\Models\Language;
use App\Models\LocationSettings;
use App\Models\Order;
use App\Models\Province;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CharitiesDashboardController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth.web', 'isAssociation']);
    }

    /**
     * Show the application dashboard.
     */
    public function index(LocationSettings $locationSetting = null): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $association = Association::whereUserId(\Auth::id())->first();
        if (!$association) {
            return Redirect::to('/' . AppHelper::getSlug());
        }
        $containers = Container::whereAssociationId($association->id);
        $orders = Order::whereAssociationId($association->id);
        $containersCount = $containers->count();
        $ordersWeight = $orders->sum('weight');
        $ordersCount = $orders->count();
        $ordersValue = Order::whereAssociationId($association->id)
            ->where('payment_status', '=', PaymentStatus::UNPAID)
            ->sum('value');
        $associationContainer = $containers
            ->has('details')
            ->with('details')->get();
        $containerWeight = 0;
        $containerValue = 0;
        foreach ($associationContainer as $container)
        {
            $containerWeight += $container->details()->sum('weight');
            $containerValue += $container->details()->where('status', '=', PaymentStatus::UNPAID)->sum('value');
        }

        $totalWeight = $containerWeight + $ordersWeight;
        $financial = $containerValue + $ordersValue;

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

        return view('auth.charities.charities-dashboard', [
            'association' => $association,
            'orderCounts' => $ordersCount,
            'containersCount' => $containersCount,
            'totalWeight' => $totalWeight,
            'financial' => $financial,
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
        ]);
    }

    public function orders(LocationSettings $locationSetting = null)
    {
        $association = Association::whereUserId(\Auth::id())->first();
        if (!$association) {
            return Redirect::to('/' . AppHelper::getSlug());
        }

        $endDataValidate = ['date_format:Y-m-d'];
        $request = request()->all();
        if (isset($request)) {
            if (isset($request['start_date']))
                $endDataValidate = array_merge($endDataValidate, ['after_or_equal:' . $request['start_date']]);
        }
        $validator = Validator::make($request, [
            'id' => ['max:255'],
            'name' => ['max:255'],
            'phone' => ['max:255'],
            'start_date' => ['date_format:Y-m-d'],
            'end_date' => $endDataValidate,
            'status' => Rule::in(OrderStatus::getValues()),
        ]);

        if ($validator->fails()) {
            return response(['error' => true, 'message' => $validator->errors()], 422);
        }
        $data = collect($request);

        $query = Order::query()->where('association_id', '=', $association->id);

        if ($data->has('id'))
            $query->where('id', '=', $data->get('id'));

        if ($data->has('status'))
            $query->where('status', '=', $data->get('status'));

        if ($data->has('name'))
            $query->whereHas('customer', function (Builder $query) use ($data) {
                $value = $data->get('name');
                $query->where('name', 'like', "%$value%");
            });

        if ($data->has('phone'))
            $query->whereHas('customer', function (Builder $query) use ($data) {
                $value = $data->get('phone');
                $query->where('phone', 'like', "%$value%");
            });

        if ($data->has('start_date') and $data->has('end_date')) {
            $query->whereBetween('created_at', [$data->get('start_date'), $data->get('end_date')]);
        } elseif ($data->has('start_date')) {
            $query->where('created_at', '>=', $data->get('start_date'));
        } elseif ($data->has('end_date')) {
            $query->where('created_at', '<=', $data->get('end_date'));
        }

        $orders = $query->with('customer')->latest()->paginate(10);

        $languages = Language::all();
        $settings = Setting::whereCountryId($locationSetting->country_id)?->first();
        $settings = $settings ?? Setting::where(['country_id' => null])->first();
        if ($locationSetting->language->code == 'ar')
            $currency = $settings->currency_ar;
        else
            $currency = $settings->currency_en;
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }
        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSetting);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);

        return view('auth.charities.charity-orders', [
            'locationSettings' => $locationSetting['structure'],
            'orders' => $orders,
            'languages' => $allLanguages,
            'pagination' => $orders,
            'currency' => $currency,
        ]);
    }

    public function fetch_orders(Request $request, LocationSettings $locationSetting = null)
    {
        if (request()->ajax()) {
            $association = Association::whereUserId(\Auth::id())->first();
            if (!$association) {
                return Redirect::to('/' . AppHelper::getSlug());
            }

            $endDataValidate = ['date_format:Y-m-d'];
            $request = request()->all();
            if (isset($request)) {
                if (isset($request['start_date']))
                    $endDataValidate = array_merge($endDataValidate, ['after_or_equal:' . $request['start_date']]);
            }
            $validator = Validator::make($request, [
                'id' => ['max:255'],
                'name' => ['max:255'],
                'phone' => ['max:255'],
                'start_date' => ['date_format:Y-m-d'],
                'end_date' => $endDataValidate,
                'status' => Rule::in(OrderStatus::getValues()),
            ]);

            if ($validator->fails()) {
                return response(['error' => true, 'message' => $validator->errors()], 422);
            }
            $data = collect($request);

            $query = Order::query()->where('association_id', '=', $association->id);

            if ($data->has('id'))
                $query->where('id', '=', $data->get('id'));

            if ($data->has('status'))
                $query->where('status', '=', $data->get('status'));

            if ($data->has('name'))
                $query->whereHas('customer', function (Builder $query) use ($data) {
                    $value = $data->get('name');
                    $query->where('name', 'like', "%$value%");
                });

            if ($data->has('phone'))
                $query->whereHas('customer', function (Builder $query) use ($data) {
                    $value = $data->get('phone');
                    $query->where('phone', 'like', "%$value%");
                });

            if ($data->has('start_date') and $data->has('end_date')) {
                $query->whereBetween('created_at', [$data->get('start_date'), $data->get('end_date')]);
            } elseif ($data->has('start_date')) {
                $query->where('created_at', '>=', $data->get('start_date'));
            } elseif ($data->has('end_date')) {
                $query->where('created_at', '<=', $data->get('end_date'));
            }

            $orders = $query->with('customer')->latest()->paginate(10);

            $languages = Language::all();
            $settings = Setting::whereCountryId($locationSetting->country_id)?->first();
            $settings = $settings ?? Setting::where(['country_id' => null])->first();
            if ($locationSetting->language->code == 'ar')
                $currency = $settings->currency_ar;
            else
                $currency = $settings->currency_en;

            foreach ($languages as $language) {
                $allLanguages[] = $language->languageToComponent();
            }
            $uri = $_SERVER['REQUEST_URI'];
            AppHelper::setSection($uri, $locationSetting);
            app()->setLocale($locationSetting->language->code);


            return view('auth.components.orders-charity-table', [
                'locationSettings' => $locationSetting['structure'],
                'orders' => $orders,
                'languages' => $allLanguages,
                'currency' => $currency,
            ])->render();
        }
    }

    public function containers(LocationSettings $locationSetting = null)
    {
        $association = Association::whereUserId(\Auth::id())->first();
        if (!$association) {
            return Redirect::to('/' . AppHelper::getSlug());
        }

        $endDataValidate = ['date_format:Y-m-d'];
        $request = request()->all();
        if (isset($request)) {
            if (isset($request['start_date']))
                $endDataValidate = array_merge($endDataValidate, ['after_or_equal:' . $request['start_date']]);
        }

        $validator = Validator::make($request, [
            'id' => ['max:255'],
            'code' => ['max:255'],
            'province_id' => [Rule::exists(Province::class, 'id')],
            'start_date' => ['date_format:Y-m-d'],
            'end_date' => $endDataValidate,
            'type' => Rule::in(ContainerType::getValues()),
        ]);

        if ($validator->fails()) {
            return response(['error' => true, 'message' => $validator->errors()], 422);
        }

        $data = collect($request);

        $query = Container::query()->where('association_id', '=', $association->id);


        if ($data->has('id'))
            $query->where('id', '=', $data->get('id'));

        if ($data->has('code')) {
            $value = $data->get('code');
            $query->where('code', 'like', "%$value%");
        }

        if ($data->has('province_id'))
            $query->where('province_id', '=', $data->get('province_id'));

        if ($data->has('type'))
            $query->where('type', '=', $data->get('type'));


        if ($data->has('start_date') and $data->has('end_date')) {
            $query->whereBetween('created_at', [$data->get('start_date'), $data->get('end_date')]);
        } elseif ($data->has('start_date')) {
            $query->where('created_at', '>=', $data->get('start_date'));
        } elseif ($data->has('end_date')) {
            $query->where('created_at', '<=', $data->get('end_date'));
        }

        $containers = $query->latest()->paginate(10);

        $languages = Language::all();
        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSetting);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }

        return view('auth.charities.charity-containers', [
            'containers' => $containers,
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
            'pagination' => $containers,
            'provinces' => Province::whereCountryId($locationSetting->country_id)->get(),
        ]);
    }

    public function fetch_containers(LocationSettings $locationSetting = null)
    {
        if (request()->ajax()) {
            $association = Association::whereUserId(\Auth::id())->first();
            if (!$association) {
                return Redirect::to('/' . AppHelper::getSlug());
            }

            $endDataValidate = ['date_format:Y-m-d'];
            $request = request()->all();
            if (isset($request)) {
                if (isset($request['start_date']))
                    $endDataValidate = array_merge($endDataValidate, ['after_or_equal:' . $request['start_date']]);
            }

            $validator = Validator::make($request, [
                'id' => ['max:255'],
                'code' => ['max:255'],
                'province_id' => [Rule::exists(Province::class, 'id')],
                'start_date' => ['date_format:Y-m-d'],
                'end_date' => $endDataValidate,
                'type' => Rule::in(ContainerType::getValues()),
            ]);

            if ($validator->fails()) {
                return response(['error' => true, 'message' => $validator->errors()], 422);
            }

            $data = collect($request);

            $query = Container::query()->where('association_id', '=', $association->id);


            if ($data->has('id'))
                $query->where('id', '=', $data->get('id'));

            if ($data->has('code')) {
                $value = $data->get('code');
                $query->where('code', 'like', "%$value%");
            }


            if ($data->has('province_id'))
                $query->where('province_id', '=', $data->get('province_id'));

            if ($data->has('type'))
                $query->where('type', '=', $data->get('type'));


            if ($data->has('start_date') and $data->has('end_date')) {
                $query->whereBetween('created_at', [$data->get('start_date'), $data->get('end_date')]);
            } elseif ($data->has('start_date')) {
                $query->where('created_at', '>=', $data->get('start_date'));
            } elseif ($data->has('end_date')) {
                $query->where('created_at', '<=', $data->get('end_date'));
            }

            $containers = $query->latest()->paginate(10);

            $languages = Language::all();
            $uri = $_SERVER['REQUEST_URI'];
            $str = AppHelper::setSection($uri, $locationSetting);
            app()->setLocale($locationSetting->language->code);

            foreach ($languages as $language) {
                $allLanguages[] = $language->languageToComponent();
            }

            return view('auth.charities.charity-containers-table', [
                'containers' => $containers,
                'locationSettings' => $locationSetting['structure'],
                'languages' => $allLanguages,
                'provinces' => Province::whereCountryId($locationSetting->country_id)->get(),
            ]);
        }
    }

    public function expense(LocationSettings $locationSetting = null)
    {
        $association = Association::whereUserId(\Auth::id())->first();
        if (!$association) {
            return Redirect::to('/' . AppHelper::getSlug());
        }
        $allExpenses = Expense::whereAssociationId($association->id)->latest();
        $expenses = $allExpenses->paginate(10);
        if (request()->has('filter') && request()->input('filter') != 'All') {
            if (request()->input('filter') == 'payed')
                $expenses = $allExpenses->where('status', '=', ExpenseStatus::PAYED)->paginate(10);
            elseif (request()->input('filter') == 'processing')
                $expenses = $allExpenses->where('status', '=', ExpenseStatus::PROCESSING)->paginate(10);

        } elseif (request()->has('filter') && request()->input('filter') == 'All') {
            $expenses = $allExpenses->paginate(10);
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

        $settings = Setting::whereCountryId($locationSetting->country_id)?->first();
        $settings = $settings ?? Setting::where(['country_id' => null])->first();
        if ($locationSetting->language->code == 'ar')
            $currency = $settings->currency_ar;
        else
            $currency = $settings->currency_en;

        return view('auth.charities.expense', [
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
            'expenses' => $expenses,
            'currency' => $currency,
        ]);

    }

    public function fetch_expense(LocationSettings $locationSetting = null)
    {
        if (request()->ajax()) {
            $association = Association::whereUserId(\Auth::id())->first();
            if (!$association) {
                return Redirect::to('/' . AppHelper::getSlug());
            }
            $allExpenses = Expense::whereAssociationId($association->id)->latest();
            $expenses = $allExpenses->paginate(10);
            if (request()->has('filter') && request()->input('filter') != 'All') {
                if (request()->input('filter') == 'payed')
                    $expenses = $allExpenses->where('status', '=', ExpenseStatus::PAYED)->paginate(10);
                elseif (request()->input('filter') == 'processing')
                    $expenses = $allExpenses->where('status', '=', ExpenseStatus::PROCESSING)->paginate(10);

            } elseif (request()->has('filter') && request()->input('filter') == 'All') {
                $expenses = $allExpenses->paginate(10);
            }
            $languages = Language::all();
            foreach ($languages as $language) {
                $allLanguages[] = $language->languageToComponent();
            }
            $uri = $_SERVER['REQUEST_URI'];
            AppHelper::setSection($uri, $locationSetting);
            app()->setLocale($locationSetting->language->code);

            $settings = Setting::whereCountryId($locationSetting->country_id)?->first();
            $settings = $settings ?? Setting::where(['country_id' => null])->first();
            if ($locationSetting->language->code == 'ar')
                $currency = $settings->currency_ar;
            else
                $currency = $settings->currency_en;


            return view('auth.charities.expense-table', [
                'locationSettings' => $locationSetting['structure'],
                'languages' => $allLanguages,
                'expenses' => $expenses,
                'currency' => $currency,
            ]);
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function addExpense()
    {
        $user = \Auth::user();
        $association = Association::whereUserId($user->id)->first();
        if (!$association) {
            return Redirect::to('/' . AppHelper::getSlug());
        }
        $order = Order::whereAssociationId($association->id)->where('payment_status', '=', PaymentStatus::UNPAID);
        $orderWeight = $order->clone()->sum('weight');
        $orderValue = $order->clone()->sum('value');
        $associationContainer = Container::whereAssociationId($association->id)->has('details')
            ->with('details')->get();
        $containerWeight = 0;
        $containerValue = 0;
        $containerCount = 0;

        foreach ($associationContainer as $container)
        {
            $weight = $container->details()->where('status', '=', PaymentStatus::UNPAID)->sum('weight');
            $containerWeight += $weight;
            $containerValue += $container->details()->where('status', '=', PaymentStatus::UNPAID)->sum('value');
            if ($weight != 0)
                $containerCount += 1;
            $container->details()->update(['status' => PaymentStatus::PAID]);
        }
        $orderCount = $order->clone()->count();
        $order->update(['payment_status' => PaymentStatus::PAID]);
        $value = $containerValue + $orderValue;

        if ($value > 0) {
            $expense = Expense::create([
                'containers_count' => $containerCount,
                'orders_count' => $orderCount,
                'orders_weight' => $orderWeight,
                'containers_weight' => $containerWeight,
                'weight' => $containerWeight + $orderWeight,
                'value' => $value,
                'date' => Carbon::now('UTC'),
                'status' => ExpenseStatus::PROCESSING,
                'association_id' => $association->id,
            ]);
            AssociationExpenseRequestEvent::dispatch($expense);
        }

        return Redirect::to('/' . AppHelper::getSlug() . '/association/expense');
    }

    public function chartBar()
    {
        if (!request()->has('months-select'))
            $months = 1;
        else
            $months = (request()->input('months-select'));

        $association = Association::whereUserId(\Auth::id())->first();
        if (!$association) {
            return Redirect::to('/' . AppHelper::getSlug());
        }
        $monthsName = [];
        $ordersWeight = [];
        $containerWeight = [];
        $totalWeight = [];
        $associationOrders = Order::whereAssociationId($association->id)->select(['created_at', 'weight']);
        $associationContainer = Container::whereAssociationId($association->id)->has('details')->with('details');

        $associationContainerDetails = ContainerDetails::whereHas('container', function ($query) use ($association) {
            $query->where('association_id', $association->id);
        });

        //Code
        for ($i = 0; $i < $months; $i++) {
            $associationFilter = $associationOrders->clone();
            $associationFilterContainer = $associationContainerDetails->clone();
            $monthsName[] = Carbon::now()->subMonths($i)->monthName;
            if (Carbon::now()->subMonths($i)->month > Carbon::now()->month)
            {
                $ordersWeight[] = $associationFilter
                    ->whereYear('created_at', Carbon::now()->subYear()->year)
                    ->whereMonth('created_at', Carbon::now()->subMonths($i)->month)
                    ->sum('weight');

                $containerWeight[] = $associationFilterContainer
                    ->whereYear('date', Carbon::now()->subYear()->year)
                    ->whereMonth('date', Carbon::now()->subMonths($i)->month)
                    ->sum('weight');
            }

            else {
                $ordersWeight[] = $associationFilter
                    ->whereMonth('created_at', Carbon::now()->subMonths($i)->month)
                    ->sum('weight');

                $containerWeight[] = $associationFilterContainer
                    ->whereMonth('date', Carbon::now()->subMonths($i)->month)
                    ->sum('weight');
            }

            $totalWeight[] += $ordersWeight[$i] + $containerWeight[$i];
        }

        return view('auth.charities.charities-line-bar-chart-grouped', [
            'monthsName' => $monthsName,
            'orders' => $ordersWeight,
            'containers' => $containerWeight,
            'total' => $totalWeight,
        ]);
    }

    public function chartLine()
    {
        if (!request()->has('months-select'))
            $months = 1;
        else
            $months = (request()->input('months-select'));

        $association = Association::whereUserId(\Auth::id())->first();
        if (!$association) {
            return Redirect::to('/' . AppHelper::getSlug());
        }
        $expense = Expense::whereAssociationId($association->id);
        $monthsName = [];
        $expenseValues = [];

        for ($i = 0; $i < $months; $i++) {
            $associationFilter = $expense->clone();
            $monthsName[] = Carbon::now()->subMonths($i)->monthName;
            if (Carbon::now()->subMonths($i)->month > Carbon::now()->month)
            {
                $expenseValues[] = $associationFilter
                    ->whereYear('date', Carbon::now()->subYear()->year)
                    ->whereMonth('date', Carbon::now()->subMonths($i)->month)
                    ->sum('value');
            }

            else {
                $expenseValues[] = $associationFilter
                    ->whereMonth('date', Carbon::now()->subMonths($i)->month)
                    ->sum('value');
            }
        }

        return view('auth.charities.charities-line-chart', [
            'monthsName' => $monthsName,
            'expenses' => $expenseValues,
        ]);
    }

    public function containersDetails(LocationSettings $locationSetting = null)
    {
        $association = Association::whereUserId(\Auth::id())->first();
        if (!$association) {
            return Redirect::to('/' . AppHelper::getSlug());
        }
        $endDataValidate = ['date_format:Y-m-d'];
        $request = request()->all();
        if (isset($request)) {
            if (isset($request['start_date']))
                $endDataValidate = array_merge($endDataValidate, ['after_or_equal:' . $request['start_date']]);
        }

        $validator = Validator::make($request, [
            'id' => ['max:255'],
            'code' => ['max:255'],
            'province_id' => [Rule::exists(Province::class, 'id')],
            'start_date' => ['date_format:Y-m-d'],
            'end_date' => $endDataValidate,
            'type' => Rule::in(ContainerType::getValues()),
        ]);

        if ($validator->fails()) {
            return response(['error' => true, 'message' => $validator->errors()], 422);
        }

        $data = collect($request);
        $settings = Setting::whereCountryId($locationSetting->country_id)?->first();
        $settings = $settings ?? Setting::where(['country_id' => null])->first();
        if ($locationSetting->language->code == 'ar')
            $currency = $settings->currency_ar;
        else
            $currency = $settings->currency_en;

        $query = ContainerDetails::query()->whereHas('container', function ($query) use ($association) {
            $query->where('association_id', $association->id);
        });

        if ($data->has('id'))
            $query->whereHas('container', function ($query) use ($data) {
                $query->where('id', $data->get('id'));
            });

        if ($data->has('code'))
            $query->whereHas('container', function ($query) use ($data) {
                $query->where('code', $data->get('code'));
            });

        if ($data->has('type'))
            $query->whereHas('container', function ($query) use ($data) {
                $query->where('type', $data->get('type'));
            });

        if ($data->has('province_id'))
            $query->whereHas('container', function ($query) use ($data) {
                $query->where('province_id', $data->get('province_id'));
            });

        if ($data->has('start_date') and $data->has('end_date')) {
            $query->whereBetween('date', [$data->get('start_date'), $data->get('end_date')]);
        } elseif ($data->has('start_date')) {
            $query->where('date', '>=', $data->get('start_date'));
        } elseif ($data->has('end_date')) {
            $query->where('date', '<=', $data->get('end_date'));
        }

        $containersDetails = $query->latest()->with('container')->paginate(10);

        $languages = Language::all();
        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSetting);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }

        return view('auth.charities.charity-containers-details', [
            'containersDetails' => $containersDetails,
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
            'pagination' => $containersDetails,
            'currency' => $currency,
            'provinces' => Province::whereCountryId($locationSetting->country_id)->get(),
        ]);
    }

    public function fetchContainersDetails(Request $request, LocationSettings $locationSetting = null)
    {
        if (request()->ajax()) {
            $association = Association::whereUserId(\Auth::id())->first();
            if (!$association) {
                return Redirect::to('/' . AppHelper::getSlug());
            }

            $endDataValidate = ['date_format:Y-m-d'];
            $request = request()->all();
            if (isset($request)) {
                if (isset($request['start_date']))
                    $endDataValidate = array_merge($endDataValidate, ['after_or_equal:' . $request['start_date']]);
            }

            $validator = Validator::make($request, [
                'id' => ['max:255'],
                'code' => ['max:255'],
                'province_id' => [Rule::exists(Province::class, 'id')],
                'agent_name' => ['max:255'],
                'type' => Rule::in(ContainerType::getValues()),
                'start_date' => ['date_format:Y-m-d'],
                'end_date' => $endDataValidate,
            ]);

            if ($validator->fails()) {
                return response(['error' => true, 'message' => $validator->errors()], 422);
            }

            $data = collect($request);
            $settings = Setting::whereCountryId($locationSetting->country_id)?->first();
            $settings = $settings ?? Setting::where(['country_id' => null])->first();
            if ($locationSetting->language->code == 'ar')
                $currency = $settings->currency_ar;
            else
                $currency = $settings->currency_en;

            $query = ContainerDetails::query()->whereHas('container', function ($query) use ($association) {
                $query->where('association_id', $association->id);
            });

            if ($data->has('id'))
                $query->whereHas('container', function ($query) use ($data) {
                    $query->where('id', $data->get('id'));
                });

            if ($data->has('code'))
                $query->whereHas('container', function ($query) use ($data) {
                    $value = $data->get('code');
                    $query->where('code', 'like', "%$value%");
                });

            if ($data->has('agent_name'))
                $query->whereHas('agent', function ($query) use ($data) {
                    $value = $data->get('agent_name');
                    $query->where('name', 'like', "%$value%");
                });

            if ($data->has('type'))
                $query->whereHas('container', function ($query) use ($data) {
                    $query->where('type', $data->get('type'));
                });

            if ($data->has('province_id'))
                $query->whereHas('container', function ($query) use ($data) {
                    $query->where('province_id', $data->get('province_id'));
                });

            if ($data->has('start_date') and $data->has('end_date')) {
                $query->whereBetween('date', [$data->get('start_date'), $data->get('end_date')]);
            } elseif ($data->has('start_date')) {
                $query->where('date', '>=', $data->get('start_date'));
            } elseif ($data->has('end_date')) {
                $query->where('date', '<=', $data->get('end_date'));
            }

            $containersDetails = $query->latest()->with('container')->paginate(10);

            $languages = Language::all();
            $uri = $_SERVER['REQUEST_URI'];
            $str = AppHelper::setSection($uri, $locationSetting);
            app()->setLocale($locationSetting->language->code);
            session()->put('slug', $locationSetting->slug);
            session()->put('section', $str);
            foreach ($languages as $language) {
                $allLanguages[] = $language->languageToComponent();
            }

            return view('auth.charities.charity-containers-details-table', [
                'containersDetails' => $containersDetails,
                'locationSettings' => $locationSetting['structure'],
                'languages' => $allLanguages,
                'pagination' => $containersDetails,
                'currency' => $currency,
                'provinces' => Province::whereCountryId($locationSetting->country_id)->get(),
            ]);
        }
    }
}
