<?php

namespace App\Helpers;

use App;
use App\Enums\IpStatus;
use App\Enums\TemplateVariableType;
use App\Http\Resources\Message\MessageResource;
use App\Models\Country;
use App\Models\IP;
use App\Models\Language;
use App\Models\LocationSettings;
use App\Models\MediaModel;
use App\Models\Message;
use App\Models\Setting;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use ipinfo\ipinfo\IPinfo;
use ipinfo\ipinfo\IPinfoException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AppHelper
{
    /**
     * @throws IPinfoException
     */
    public static function getCurrentCountry(): Country|null
    {
        if (App::environment(['testing', 'local'])) {
            return Setting::where(['country_id' => null])->first()->defaultCountry;
        }
        $country = '';
        $ip = request()->header('CF-Connecting-IP') 
                ?? request()->header('X-Forwarded-For') 
                ?? request()->ip();
        if (Cache::has('ip-' . $ip)) {
            $country = Cache::get('ip-' . $ip);

            return Country::whereCode($country)->first();
        } else {
            $access_token = config('app.ip_info');
            $client = new IPinfo($access_token);
            $details = $client->getDetails($ip);
            $details = collect($details);
            if ($details->has('country'))
                $country = $details->get('country');
        }

        $countryModel = Country::whereCode($country)->first();
        if ($countryModel == null) {
            $defaultCountry = Setting::where(['country_id' => null])->first()->defaultCountry;
            if ($defaultCountry != null) {
                $countryModel = Country::whereCode($defaultCountry->code)->first();
            }
        }
        Cache::put('ip-' . $ip, $countryModel->code);

        return $countryModel;
    }

    /**
     * @throws IPinfoException
     */
    public static function getCoutnryForMobile()
    {
        $country_code = request()->header('country');
        $countryModel = Country::whereCode($country_code)->first();
        if ($countryModel == null) {
            $countryModel = self::getCurrentCountry();
        }

        return $countryModel;
    }

    public static function getLanguageForMobile(): array|string|null
    {
        $language_code = request()->header('language');
        $language = Language::whereCode($language_code)->first();
        if ($language == null) {
            $setting = Setting::where(['country_id' => null])->first();
            if ($setting != null) {
                $language_code = $setting->language->code;
            } else {
                $language_code = 'en';
            }
        }

        return $language_code;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function getLocationSettings(): LocationSettings
    {
        $locationSetting = LocationSettings::where('slug', self::getSlug())->first();

        if ($locationSetting == null) {
            $settings = Setting::where(['country_id' => null])->first();
            $locationSetting = LocationSettings::where('slug', $settings?->slug)->first();
            session()->put('slug', $locationSetting->slug);

            return $locationSetting;
        }

        return $locationSetting;
    }

    public static function getDateFormat($date): string
    {
        return Carbon::parse($date)->format('d M y');
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function getSlug(): string
    {
        $slug = 'slug';
        if (!session()->get($slug)) {
            $locationSetting = Setting::where(['country_id' => null])->first();
            session()->put($slug, $locationSetting->slug);
        }

        return session()->get($slug);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public static function getSection()
    {
        $section = 'section';

        return session()->get($section);
    }

    /**
     * @param $uri
     * @param LocationSettings|null $locationSetting
     * @return string
     */
    public static function setSection($uri, LocationSettings $locationSetting = null): string
    {
        $index = strpos($uri, $locationSetting->slug) + strlen($locationSetting->slug);
        $str = substr($uri, $index);
        $str = str_replace('//', '/', $str);
        $str = ltrim($str, $str[0]);

        return $str;
    }

    /**
     * @throws IPinfoException
     */
    public static function getMessage($model, $type, $languageId = null, $countryId = null, $content = null): array|string|null
    {
        if ($content == null) {
            $baseMessage = new MessageResource(Message::where([
                'country_id' => $countryId ?? self::getCoutnryForMobile()->id,
                'language_id' => $languageId ?? Language::whereCode(self::getLanguageForMobile())->first()->id,
                'type' => $type,])
                ->first());
            $content = $baseMessage->content ?? null;
        }
        $className = get_class($model);
        $keys = [];
        $result = [];
        $string = '';
        $found = 0;
        $message = str_split($content);
        foreach ($message as $char) {
            if ($char == '$')
                $found = 1;
            if ($char == ' ') {
                if ($found == 1)
                    $keys[] = ' ';
                $found = 0;
            }
            if ($found == 1) {
                $keys[] = $char;
            }
        }
        foreach ($keys as $key => $value) {
            if ($value != ' ') {
                $string .= $value;
            }
            if ($value == ' ' or $key == count($keys) - 1) {
                $result[] = $string . ' ';
                $string = '';
            }
        }
        if (str_contains($className, 'Order'))
            $values = collect(TemplateVariableType::getTemplateVariablesList($model));
        elseif (str_contains($className, 'Expense'))
            $values = collect(TemplateVariableType::getTemplateVariablesListExpense($model));
        elseif (str_contains($className, 'Invoice'))
            $values = collect(TemplateVariableType::getTemplateVariablesListInvoice($model));

        foreach ($result as $item) {
            $tempKey = ltrim($item, $item[0]);
            $tempKey = rtrim($tempKey);
            $replaceWord = trim($item);
            if ($values->get($tempKey))
                $content = str_replace($replaceWord, $values->get($tempKey), $content);
        }

        return $content;
    }

    /**
     * @throws GuzzleException
     */
    public static function setCountryInfo(Model|Country $country): void
    {
        if (!App::environment('testing', 'local')) {
            if ($country->flag == null) {
                $client = new Client();
                $request = $client->get('https://restcountries.com/v3.1/alpha/' . $country->code);
                $countryFlag = json_decode($request->getBody())[0]->flags->png;
                $countryCodeNumber = json_decode($request->getBody())[0]->idd->root . json_decode($request->getBody())[0]->idd->suffixes[0];
                $countryCIOC = json_decode($request->getBody())[0]->cioc;
                MediaModel::getDisk()->put("$countryCIOC.png", file_get_contents($countryFlag));
                $country->flag = MediaModel::getDisk()->url("$countryCIOC.png");
                $country->code_number = $countryCodeNumber;
                $country->ico = $countryCIOC;
                $country->save();
                $country->refresh();
            }
        }
    }

    public static function getLatLang(Country $country, $province = null, $title = null, LocationSettings $locationSetting = null, $buildingNumber = null): array
    {
        $country_name = $country->meta['translate']['name_en'];
        if ($title == null)
            $title = '';

        if ($buildingNumber == null)
            $buildingNumber = '';

        if ($province == null)
            $province = '';

        else {
            if ($locationSetting != null) {
                $province = $province->meta['translate']['name' . '_' . $locationSetting->language->code];
                $country_name = $country->meta['translate']['name' . '_' . $locationSetting->language->code];
            } else
                $province = $province->meta['translate']['name_en'];

        }

        if (App::environment(['testing', 'local'])) {
            return [
                'lat' => 0,
                'lng' => 0,
            ];
        }

        $searchWord = $buildingNumber . ', ' . $title . ', ' . $province . ', ' . $country_name;
        $result = app('geocoder')->geocode($searchWord)->get();
        $coordinates = $result[0]->getCoordinates();
        $lat = $coordinates->getLatitude();
        $long = $coordinates->getLongitude();

        return [
            'lat' => $lat,
            'lng' => $long,
        ];

    }

    public static function getLatLngForWebsite(Country $country, $province = null, $areaName = null, $streetName = null, $buildingName = null, LocationSettings $locationSetting = null): array
    {
        $country_name = $country->meta['translate']['name_en'];

        $buildingName = $buildingName ?? '';
        $streetName = $streetName ?? '';
        $neighborhoodName = $neighborhoodName ?? '';
        $areaName = $areaName ?? '';
        $provinceName = $province ? $province->meta['translate']['name_en'] : '';

        if ($locationSetting != null) {
            $country_name = $country->meta['translate']['name' . '_' . $locationSetting->language->code];
            $provinceName = $province ? $province->meta['translate']['name' . '_' . $locationSetting->language->code] : '';
        }

        $searchWord = implode(', ', array_filter([$buildingName, $streetName, $neighborhoodName, $areaName, $provinceName, $country_name]));

        if (App::environment(['testing', 'local'])) {
            return ['lat' => 0, 'lng' => 0];
        }

        $result = app('geocoder')->geocode($searchWord)->get();
        if (!empty($result)) {
            $coordinates = $result[0]->getCoordinates();
            $lat = $coordinates->getLatitude();
            $lng = $coordinates->getLongitude();

            return ['lat' => $lat, 'lng' => $lng];
        }

        return ['lat' => 0, 'lng' => 0];
    }

    public static function changeDateFormat($date): string
    {
        return Carbon::createFromDate($date)->format('c');
    }

    public static function checkIP(): bool
    {
        if (App::environment(['testing', 'local']))
            return true;

        if(!empty(request()->server('HTTP_CF_CONNECTING_IP')))
            $userIP = request()->server('HTTP_CF_CONNECTING_IP');
        else
            $userIP = request()->ip();
        $recordIP = IP::where('ip_address', '=', $userIP)->first();
        if ($recordIP) {
            if ($recordIP->status == IpStatus::ACTIVE)
                return true;
            else {
                Log::info("IP INACTIVE: {$userIP}");

                return false;
            }
        }
        else {
            Log::info("IP not found in database: {$userIP}");

            return false;
        }
    }
}

