<?php

namespace App\Http\Resources\Item;

use App\Helpers\AppHelper;
use App\Http\Resources\Country\CountryResource;
use App\Models\Item;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Item
 **/
class SimpleItemResource extends JsonResource
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
            'title' => $this->getTranslateValue($locale, $this->meta, 'title', $this->title),
            'image' => $this->image_path,
            'price_per_kg' => $this->price_per_kg,
            'weight' => $this->pivot ? $this->pivot->weight : null,
        ];
    }

    public function getCountryResource(): ?CountryResource
    {
        if (!$this->country) {
            return null;
        }

        return new CountryResource($this->country);
    }
}
