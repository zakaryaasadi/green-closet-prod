<?php

namespace App\Http\Resources\Offer;

use App\Helpers\AppHelper;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Partner\SimplePartnerResource;
use App\Models\Offer;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Offer
 **/
class OfferResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $locale = AppHelper::getLanguageForMobile();

        return [
            'id' => $this->id,
            'name' => $this->getTranslateValue($locale, $this->meta, 'name', $this->name),
            'value' => $this->value,
            'type' => $this->type,
            'country' => $this->getCountryResource(),
            'partner' => $this->getPartnerResource(),
            'meta' => $this->meta,
            'image' => $this->image_path,
        ];
    }

    public function getCountryResource(): ?CountryResource
    {
        if ($this->country == null) return null;

        return new CountryResource($this->country);
    }

    public function getPartnerResource(): ?SimplePartnerResource
    {
        if ($this->partner == null) return null;

        return new SimplePartnerResource($this->partner);
    }
}
