<?php

namespace App\Http\Resources\Partner;

use App\Helpers\AppHelper;
use App\Http\Resources\Country\CountryResource;
use App\Models\Partner;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Partner
 **/
class PartnerResource extends JsonResource
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
            'description' => $this->getTranslateValue($locale, $this->meta, 'description', $this->description),
            'image' => $this->image_path,
            'meta' => $this->meta,
            'url' => $this->url,
            'country' => $this->getCountry(),
        ];
    }

    public function getCountry(): ?CountryResource
    {
        if ($this->country_id == null) return null;

        return new CountryResource($this->country);
    }
}
