<?php

namespace App\Traits;

use App;
use App\Helpers\AppHelper;
use App\Models\Setting;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use ipinfo\ipinfo\IPinfoException;
use libphonenumber\NumberParseException;
use Propaganistas\LaravelPhone\PhoneNumber;

trait SmsService
{
    /**
     * @throws IPinfoException
     * @throws GuzzleException
     */
    public static function sendSMS($phone, $code = null, $message = null, User $user = null, $country = null): void
    {
        $userName = config('integrations.sms.user_name');
        $password = config('integrations.sms.password');
        $senderId = config('integrations.sms.sender_id');

        if ($country != null) {
            $settings = Setting::whereCountryId($country)->first();
        } else {
            $settings = Setting::whereCountryId(AppHelper::getCoutnryForMobile()->id)->first();
        }

        if ($settings != null) {
            if ($settings->sms_password != null && $settings->sms_user_name != null && $settings->sms_sender_id != null) {
                $userName = $settings->sms_user_name;
                $password = $settings->sms_password;
                $senderId = $settings->sms_sender_id;
            }
        }
        $client = new Client();
        $phoneNumber = $phone;
        $countryCode = new PhoneNumber($phoneNumber);
        try {
            $countryCode = strtok($countryCode->formatInternational(), ' ');
            if (!is_null($code)) {
                if (!is_null($user))
                    $message = 'Dear ' . $user->name . ' your code is: ' . $code;
                else
                    $message = 'Dear client your code is: ' . $code;
            }
            if (!App::environment(['testing', 'local'])) {
                $client->get(config('integrations.sms.api_url') . "?user=$userName&pwd=$password&senderid=$senderId&mobileno=$phoneNumber&CountryCode=$countryCode&msgtext=$message" . '&priority=High', []);
            }
        }
        catch (NumberParseException) {
            return;
        }
    }
}
