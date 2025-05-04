<?php

namespace App\Http\Resources\LocationSettings;

use App\Http\Resources\Country\SimpleCountryResource;
use App\Http\Resources\Language\LanguageResource;
use App\Models\LocationSettings;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin LocationSettings
 **/
class LocationSettingsResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'structure' => $this->structure,
            'scripts' => $this->scripts,
            'language' => $this->getLanguageResource(),
            'country' => $this->getCountryResource(),
            'slug' => $this->slug,
        ];
    }

    public function getCountryResource(): ?SimpleCountryResource
    {
        if ($this->country == null) return null;

        return new SimpleCountryResource($this->country);
    }

    public function getLanguageResource(): ?LanguageResource
    {
        if ($this->language == null) return null;

        return new LanguageResource($this->language);
    }
}
