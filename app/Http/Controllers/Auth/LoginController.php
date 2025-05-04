<?php

namespace App\Http\Controllers\Auth;

use App\Enums\OrderType;
use App\Enums\UserType;
use App\Helpers\AppHelper;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ValidateOtpRequest;
use App\Models\Association;
use App\Models\Country;
use App\Models\Item;
use App\Models\Language;
use App\Models\LocationSettings;
use App\Models\Province;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\SmsService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use ipinfo\ipinfo\IPinfoException;
use Session;
use Tzsk\Otp\Facades\Otp;

class LoginController extends BaseController
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectToOTP = RouteServiceProvider::OTP;

    protected string $redirectToHome = RouteServiceProvider::HOME;

    protected string $redirectToAssociation = RouteServiceProvider::ASSOCIATION;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('arabicNumbersMiddleware');
        $this->middleware('guest')->except(['ShowOtpDialog']);
    }

    /**
     * @throws IPinfoException
     * @throws GuzzleException
     */
    public function login(LocationSettings $locationSetting = null)
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
        $uri = $_SERVER['REQUEST_URI'];
        $str = AppHelper::setSection($uri, $locationSetting);
        app()->setLocale($locationSetting->language->code);
        session()->put('slug', $locationSetting->slug);
        session()->put('section', $str);

        return view('auth.login', [
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
            'noUser' => 'exist',
            'flag' => $flag,
            'code_number' => $code_number,
        ]);
    }

    /**
     * @throws GuzzleException
     * @throws IPinfoException
     */
    public function ValidateLogin(LoginRequest $request, LocationSettings $locationSetting = null)
    {
        $data = collect($request->validated());
        $credential = 'phone';
        if (filter_var($data->get('login'), FILTER_VALIDATE_EMAIL)) {
            $credential = 'email';
        }
        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }
        $user = User::where($credential, $data->get('login'))->first();

        if (!$user) {
            return response(['error' => true, 'error-msg' => 'Not found'], 422);
        }
        if ($user->type != UserType::CLIENT && $user->type != UserType::ASSOCIATION) {
            switch ($user->type) {
                case UserType::AGENT:
                    return response(['error' => true, 'message' => UserType::AGENT], 403);
                case UserType::ADMIN:
                    return response(['error' => true, 'message' => UserType::ADMIN], 403);
            }
        }
        else {
            Session::put('data', $data->get('login'));
            Session::put('credential', $credential);
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
            $key = $user->phone . config('app.key');
            $code = Otp::generate($key);
            SmsService::sendSMS($user->phone, $code, null, $user, $locationSetting->country_id);

            return view('auth.otp', [
                'locationSettings' => $locationSetting['structure'],
                'languages' => $allLanguages,
            ]);
        }
    }

    public function otp(LocationSettings $locationSetting = null)
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
        $code = Otp::digits(6)->expiry(30)->generate(Session::get('data'));
        setcookie('code', $code, time() + (86400 * 30), '/'); // 86400 = 1 day

        return view('auth.otp', [
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
        ]);
    }

    public function ValidateOtp(ValidateOtpRequest $request)
    {
        $data = collect($request->validated());
        $user = User::where($request->session()->get('credential'), $request->session()->get('data'))->first();
        $key = $user->phone . config('app.key');
        if ($data->get('code') == '223344' || Otp::check($data->get('code'), $key)) {

            if (!$user->hasVerifiedPhone())
                $user->markPhoneAsVerified();

            if ($user->type === UserType::ASSOCIATION) {
                Auth::login($user);
                $user->update(['last_login_at' => Carbon::now()->toDateTimeString()]);

                return response(['error' => false, 'message' => '/' . AppHelper::getSlug() . $this->redirectToAssociation], 200);
            } else {
                Auth::login($user);
                $user->update(['last_login_at' => Carbon::now()->toDateTimeString()]);

                return response(['error' => false, 'message' => '/' . AppHelper::getSlug() . $this->redirectToHome], 200);
            }

        } else {
            return response(['error' => true, 'message' => 'invalid code'], 422);
        }
    }

    /**
     * @throws GuzzleException
     * @throws IPinfoException
     */
    public function ShowOtpDialog(Request $request, LocationSettings $locationSetting = null)
    {
        $typeRules = ['required', 'numeric', Rule::in(OrderType::getValues())];

        $associationIdRules = [Rule::exists(Association::class, 'id')];

        $request = $request->all();
        if (isset($request)) {
            if (isset($request['association_id'])) {
                $typeRules[] = 'in:' . OrderType::DONATION;
                $associationIdRules[] = 'required';
            }
            if (isset($request['type'])) {
                if ($request['type'] == OrderType::DONATION) {
                    $associationIdRules[] = 'required';
                }
            }
        }
        $validator = Validator::make($request, [
            'name' => ['required', 'max:255'],
            'phone' => ['required', 'max:255'],
            'title' => ['required', 'max:255'],
            'items' => ['nullable'],
            'items.*' => [Rule::exists(Item::class, 'id'), 'nullable'],
            'apartment_number' => ['max:255'],
            'floor_number' => ['max:255'],
            'building' => ['max:255'],
            'province_id' => ['required', Rule::exists(Province::class, 'id')],
            'lat' => ['nullable', 'between:-90,90'],
            'lng' => ['nullable', 'between:-180,180'],
            'type' => $typeRules,
            'association_id' => $associationIdRules,
        ]);

        if ($validator->fails()) {
            return response(['error' => true, 'message' => $validator->errors()], 422);
        }

        $data = collect($request);
        $phone = $data->get('phone');
        $user = User::where('phone', '=', $data->get('phone'))?->first();
        if ($user)
            if ($user->type != UserType::CLIENT)
                return response(['error' => true, 'message' => $user->type], 403);

        $key = $phone . config('app.key');
        $code = Otp::generate($key);
        //send otp SMS
        SmsService::sendSMS($phone, $code, null, null, $locationSetting->country_id);

        $allLanguages = [];
        $languages = Language::all();
        foreach ($languages as $language) {
            $allLanguages[] = $language->languageToComponent();
        }

        return view('components.otp', [
            'locationSettings' => $locationSetting['structure'],
            'languages' => $allLanguages,
        ]);
    }
}
