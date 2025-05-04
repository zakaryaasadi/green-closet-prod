<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use App\Models\Language;
use App\Models\LocationSettings;
use App\Models\Province;
use App\Providers\RouteServiceProvider;
use Auth;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use ipinfo\ipinfo\IPinfoException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Session;

class AddressController extends BaseController
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('arabicNumbersMiddleware');
        $this->middleware(['auth.web', 'isClient']);
    }

    /**
     * @throws IPinfoException
     */
    public function address(LocationSettings $locationSetting)
    {
        $allLanguages = [];
        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }
        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSetting);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);
        app()->setLocale($locationSetting->language->code);
        session()->put('section', $str);
        Session::put('from', Session::previousUrl());
        $latLng = AppHelper::getLatLang($locationSetting->country);


        return view('auth.address', [
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
            'provinces' => Province::whereCountryId($locationSetting->country_id)->get(),
            'lat' => $latLng['lat'],
            'lng' => $latLng['lng'],
        ]);
    }

    public function addAddress(StoreAddressRequest $request): RedirectResponse
    {
        $data = collect($request->validated());

        $address = new Address();
        $address->user_id = Auth::user()->id;
        $address->country_id = AppHelper::getLocationSettings()->country_id;
        $point = new Point($data->get('lat'), $data->get('lng'));

        $address->location = $point;
        $address->location_title = $data->get('title');
        $address->location_province = $data->get('province');
        $address->province_id = $data->get('province_id');

        if ($data->has('apartment_number')) {
            $address->apartment_number = $data->get('apartment_number');

        }
        if ($data->has('floor_number')) {
            $address->floor_number = $data->get('floor_number');

        }
        if ($data->has('building')) {
            $address->building = $data->get('building');

        }

        $address->save();
        $address->refresh();

        if (Session::get('getFrom') == 'order') {
            Session::put('getFrom', '');

            return Redirect::to('/' . AppHelper::getSlug() . '/create-order');
        } else {
            return Redirect::to('/' . AppHelper::getSlug() . '/dashboard/profile');
        }
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updateAddress(LocationSettings $locationSetting, UpdateAddressRequest $request, $address)
    {
        $address = Auth::user()->addresses->where('id', '=', $address)->first();
        $data = collect($request->validated());
        if ($data->has('lat') and $data->has('lng')) {
            $point = new Point($data->get('lat'), $data->get('lng'));
            $address->location = $point;
        }

        if ($data->has('province')) {
            $address->location_province = $data->get('province');
        }

        if ($data->has('title')) {
            $address->location_title = $data->get('title');
        }

        if ($data->has('province_id')) {
            $address->province_id = $data->get('province_id');
        }
        if ($data->has('apartment_number')) {
            $address->apartment_number = $data->get('apartment_number');
        }
        if ($data->has('floor_number')) {
            $address->floor_number = $data->get('floor_number');
        }
        if ($data->has('building')) {
            $address->building = $data->get('building');

        }

        $address->save();
        $address->refresh();
        $allLanguages = [];
        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }
        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSetting);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);
        app()->setLocale($locationSetting->language->code);
        session()->put('section', $str . '/' . $address->id);

        return Redirect::to('/' . AppHelper::getSlug() . '/dashboard/profile');
    }

    public function editAddress(LocationSettings $locationSetting, Address $address)
    {
        if ($address->user_id != Auth::id())
            abort(404);

        $allLanguages = [];
        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }
        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSetting);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);
        app()->setLocale($locationSetting->language->code);
        session()->put('section', $str);

        return view('auth.edit-address', [
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
            'address' => $address,
            'provinces' => Province::whereCountryId($locationSetting->country_id)->get(),
            'address_province' => $address->province,
        ]);
    }
}
