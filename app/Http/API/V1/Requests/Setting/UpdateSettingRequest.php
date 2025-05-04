<?php

namespace App\Http\API\V1\Requests\Setting;

use App\Enums\DaysEnum;
use App\Enums\DischargeShift;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country_id' => [Rule::exists(Country::class, 'id')],
            'language_id' => [Rule::exists(Language::class, 'id')],
            'default_country_id' => [Rule::exists(Country::class, 'id')],
            'point_value' => ['numeric'],
            'point_count' => ['numeric'],
            'point_expire' => ['numeric'],
            'first_points' => ['numeric'],
            'container_limit' => ['numeric'],
            'first_points_expire' => ['numeric'],
            'container_value' => ['numeric'],
            'slug' => ['max:255'],
            'email' => ['max:255'],
            'mail_receiver' => ['max:255'],
            'sms_to_accepted' => ['in:0,1'],
            'sms_to_decline' => ['in:0,1'],
            'sms_to_cancel' => ['in:0,1'],
            'sms_to_delivering' => ['in:0,1'],
            'sms_to_failed' => ['in:0,1'],
            'currency_ar' => ['max:255'],
            'currency_en' => ['max:255'],
            'favicon' => ['max:255'],
            'location' => ['max:255'],
            'secret_key' => ['max:255'],
            'phone' => ['max:255'],
            'header_title' => ['max:255'],
            'header_title_arabic' => ['max:255'],
            'auto_assign' => ['in:0,1'],
            'has_donation' => ['in:0,1'],
            'has_recycling' => ['in:0,1'],
            'has_recycling_admin' => ['in:0,1'],
            'has_donation_admin' => ['in:0,1'],
            'send_link' => ['in:0,1'],
            'calculate_points' => ['in:0,1'],
            'points_per_order' => ['numeric'],
            'otp_active' => ['in:0,1'],
            'tasks_per_day' => ['numeric'],
            'budget' => ['numeric'],
            'holiday' => [Rule::in(DaysEnum::getValues())],
            'start_work' => ['date_format:H:i'],
            'finish_work' => ['date_format:H:i'],
            'sms_user_name' => ['max:255'],
            'sms_password' => ['max:255'],
            'sms_sender_id' => ['max:255'],
            'work_shift' => [Rule::in(DischargeShift::getValues())],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
