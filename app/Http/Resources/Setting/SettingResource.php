<?php

namespace App\Http\Resources\Setting;

use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Language\LanguageResource;
use App\Models\Setting;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Setting
 **/
class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'country' => $this->getCountryResource(),
            'language' => $this->getLanguageResource(),
            'default_country' => $this->getDefaultCountryResource(),
            'point_value' => $this->point_value,
            'point_count' => $this->point_count,
            'point_expire' => $this->point_expire,
            'first_points' => $this->first_points,
            'container_limit' => $this->container_limit,
            'first_points_expire' => $this->first_points_expire,
            'container_value' => $this->container_value,
            'slug' => $this->slug,
            'sms_user_name' => $this->sms_user_name,
            'sms_password' => $this->sms_password,
            'sms_sender_id' => $this->sms_sender_id,
            'email' => $this->email,
            'mail_receiver' => $this->mail_receiver,
            'location' => $this->location,
            'phone' => $this->phone,
            'header_title' => $this->header_title,
            'header_title_arabic' => $this->header_title_arabic,
            'auto_assign' => $this->auto_assign,
            'has_donation' => $this->has_donation,
            'has_recycling' => $this->has_recycling,
            'has_recycling_admin' => $this->has_recycling_admin,
            'has_donation_admin' => $this->has_donation_admin,
            'send_link' => $this->send_link,
            'otp_active' => $this->otp_active,
            'currency_ar' => $this->currency_ar,
            'currency_en' => $this->currency_en,
            'tasks_per_day' => $this->tasks_per_day,
            'holiday' => $this->holiday,
            'budget' => $this->budget,
            'start_work' => $this->start_work,
            'finish_work' => $this->finish_work,
            'work_shift' => $this->work_shift,
            'calculate_points' => $this->calculate_points,
            'points_per_order' => $this->points_per_order,
            'favicon' => $this->favicon,
            'sms_to_accepted' => $this->sms_to_accepted,
            'sms_to_decline' => $this->sms_to_decline,
            'sms_to_cancel' => $this->sms_to_cancel,
            'sms_to_delivering' => $this->sms_to_delivering,
            'sms_to_failed' => $this->sms_to_failed,
            'secret_key' => $this->secret_key,
        ];
    }

    public function getCountryResource(): CountryResource
    {
        return new CountryResource($this->country);
    }

    public function getLanguageResource(): LanguageResource
    {
        return new LanguageResource($this->language);
    }

    public function getDefaultCountryResource(): CountryResource
    {
        return new CountryResource($this->defaultCountry);
    }
}
