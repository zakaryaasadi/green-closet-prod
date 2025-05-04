<?php

namespace App\Http\Controllers\Auth;

use App\Enums\PointStatus;
use App\Enums\UserType;
use App\Helpers\AppHelper;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Country;
use App\Models\Language;
use App\Models\LocationSettings;
use App\Models\Point;
use App\Models\Setting;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\SmsService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use ipinfo\ipinfo\IPinfoException;
use Tzsk\Otp\Facades\Otp;

class RegisterController extends BaseController
{
    /**
     * Where to redirect users after register.
     *
     * @var string
     */
    protected string $redirectToOTP = RouteServiceProvider::OTP;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest', 'arabicNumbersMiddleware']);
    }

    /**
     * @throws IPinfoException
     * @throws GuzzleException
     */
    public function register(LocationSettings $locationSetting = null)
    {
        $country = Country::whereId($locationSetting->country_id)->first();

        AppHelper::setCountryInfo($country);

        $flag = $country->flag;
        $code_number = $country->code_number;
        $allLanguages = [];

        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }
        $locationSettings = AppHelper::getLocationSettings();

        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSettings);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);

        return view('auth.register', [
            'locationSettings' => $locationSettings['structure'],
            'languages' => $allLanguages,
            'flag' => $flag,
            'code_number' => $code_number,
        ]);
    }

    /**
     * @throws IPinfoException
     * @throws GuzzleException
     */
    public function ValidateRegister(RegisterRequest $request, LocationSettings $locationSetting = null)
    {
        $data = collect($request->validated());
        $deletedUser = User::onlyTrashed()->where('phone', $data->get('phone'))->first();
        if (User::wherePhone($data->get('phone'))->first()) {

            return response(['error' => true, 'error-msg' => 'phone already exists'], 422);
        }

        elseif ($deletedUser != null) {
            $user = $deletedUser;
            $user->restore();
            $user->type = UserType::CLIENT;
            $user->save();
            $user->refresh();
        }

        else {
            $user = new User($data->all());
            $clientCountry = AppHelper::getLocationSettings()->country;
            $user->country_id = $clientCountry->id;
            $user->save();

            //Add points
            $points = Setting::where(['country_id' => $clientCountry->id])->first()->first_points;
            $pointExpire = Setting::where(['country_id' => $clientCountry->id])->first()->first_points_expire;
            Point::create([
                'user_id' => $user->id,
                'country_id' => $clientCountry->id,
                'count' => $points,
                'ends_at' => Carbon::now('UTC')->addDays($pointExpire),
                'status' => PointStatus::ACTIVE,
                'used' => false,
            ]);
        }

        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }

        Session::put('data', $data->get('phone'));
        Session::put('credential', 'phone');
        $locationSettings = AppHelper::getLocationSettings();
        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSettings);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);
        $key = $user->phone . config('app.key');
        $code = Otp::generate($key);
        SmsService::sendSMS($user->phone, $code, null, $user, $locationSetting->country_id);

        return view('auth.otp', [
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
        ]);
    }
}
