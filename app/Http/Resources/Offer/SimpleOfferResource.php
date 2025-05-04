<?php

namespace App\Http\Resources\Offer;

use App\Enums\OfferType;
use App\Helpers\AppHelper;
use App\Models\Offer;
use App\Models\Setting;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use ipinfo\ipinfo\IPinfoException;

/**
 * @mixin Offer
 **/
class SimpleOfferResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     *
     * @throws IPinfoException
     */
    public function toArray($request): array
    {
        $locale = AppHelper::getLanguageForMobile();

        $value = $this->value;

        if ($this->type == OfferType::PERCENT)
            $value = $this->value . '%';

        if ($this->type == OfferType::FIXED) {
            $settings = Setting::whereCountryId(AppHelper::getCoutnryForMobile()->id)?->first() ?? Setting::where(['country_id' => null])?->first();
            if ($locale == 'ar')
                $currency = $settings->currency_ar;
            else
                $currency = $settings->currency_en;

            $value = $this->value . ' ' . $currency;
        }

        return [
            'id' => $this->id,
            'name' => $this->getTranslateValue($locale, $this->meta, 'name', $this->name),
            'image' => $this->image_path,
            'value' => $value,
            'type' => $this->type,
            'country' => $this->country != null ? $this->country->name : '',
            'partner' => $this->partner != null ? $this->partner->name : '',
        ];
    }
}
