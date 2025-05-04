<?php

namespace App\Http\Resources\Country;

use App\Helpers\AppHelper;
use App\Models\Country;
use App\Models\Setting;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Country
 **/
class CountryResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $locale = AppHelper::getLanguageForMobile();

         $settings = Setting::whereCountryId($this->id)->first();
         if ($settings == null) {
             $settings = Setting::whereCountryId(null)->first();
         }

        return [
            'id' => $this->id,
            'name' => $this->getTranslateValue($locale, $this->meta, 'name', $this->name),
            'meta' => $this->meta,
            'code' => $this->code,
            'flag' => $this->flag,
            'code_number' => $this->code_number,
            'status' => $this->status,
            'has_donation' => $settings == null ? 0 : $settings->has_donation == 1,
            'has_recycling' => $settings == null ? 0 : $settings->has_recycling == 1,
            'has_donation_admin' => $settings == null ? 0 : $settings->has_donation_admin == 1,
            'has_recycling_admin' => $settings == null ? 0 : $settings->has_recycling_admin == 1,
        ];
    }
}
