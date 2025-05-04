<?php

namespace App\Http\Resources\Item;

use App\Helpers\AppHelper;
use App\Http\Resources\Country\SimpleCountryResource;
use App\Models\Item;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Item
 **/
class FullItemResource extends JsonResource
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
            'country' => $this->getCountryResource(),
            'meta' => $this->meta,
        ];
    }

    public function getCountryResource(): ?SimpleCountryResource
    {
        if (!$this->country) {
            return null;
        }

        return new SimpleCountryResource($this->country);
    }
}
