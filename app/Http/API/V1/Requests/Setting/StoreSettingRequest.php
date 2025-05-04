<?php

namespace App\Http\API\V1\Requests\Setting;

use App\Enums\DaysEnum;
use App\Enums\DischargeShift;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'language_id' => ['required', Rule::exists(Language::class, 'id')],
            'default_country_id' => ['required', Rule::exists(Country::class, 'id')],
            'point_value' => ['required', 'numeric'],
            'point_count' => ['required', 'numeric'],
            'point_expire' => ['required', 'numeric'],
            'first_points' => ['required', 'numeric'],
            'container_limit' => ['required', 'numeric'],
            'first_points_expire' => ['required', 'numeric'],
            'container_value' => ['required', 'numeric'],
            'slug' => ['required', 'max:255'],
            'sms_user_name' => ['required', 'max:255'],
            'sms_password' => ['required', 'max:255'],
            'sms_sender_id' => ['required', 'max:255'],
            'email' => ['required', 'max:255'],
            'mail_receiver' => ['required', 'max:255'],
            'secret_key' => ['required', 'max:255'],
            'currency_ar' => ['max:255'],
            'currency_en' => ['max:255'],
            'location' => ['required', 'max:255'],
            'favicon' => ['required', 'max:255'],
            'phone' => ['required', 'max:255'],
            'header_title' => ['required', 'max:255'],
            'header_title_arabic' => ['required', 'max:255'],
            'auto_assign' => ['required', 'in:0,1'],
            'sms_to_accepted' => ['required', 'in:0,1'],
            'sms_to_decline' => ['required', 'in:0,1'],
            'sms_to_cancel' => ['required', 'in:0,1'],
            'sms_to_delivering' => ['required', 'in:0,1'],
            'sms_to_failed' => ['required', 'in:0,1'],
            'send_link' => ['required', 'in:0,1'],
            'has_recycling' => ['required', 'in:0,1'],
            'has_donation' => ['required', 'in:0,1'],
            'has_recycling_admin' => ['required', 'in:0,1'],
            'has_donation_admin' => ['required', 'in:0,1'],
            'calculate_points' => ['required', 'in:0,1'],
            'points_per_order' => ['required', 'numeric'],
            'otp_active' => ['required', 'in:0,1'],
            'tasks_per_day' => ['required', 'numeric'],
            'budget' => ['required', 'numeric'],
            'holiday' => ['required', Rule::in(DaysEnum::getValues())],
            'start_work' => ['required', 'date_format:H:i'],
            'finish_work' => ['required', 'date_format:H:i'],
            'work_shift' => ['required', Rule::in(DischargeShift::getValues())],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
