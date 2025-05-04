<?php

namespace App\Http\Resources\Section;

use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Language\LanguageResource;
use App\Models\Section;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Section
 **/
class SectionResource extends JsonResource
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
            'page_id' => $this->page_id,
            'page_name' => $this->page?->title ?? ' ',
            'sort' => $this->sort,
            'type' => $this->type,
            'active' => $this->active,
            'country' => $this->getCountry(),
            'language' => $this->getLanguage(),
        ];
    }

    public function getCountry(): ?CountryResource
    {
        if ($this->country_id == null) return null;

        return new CountryResource($this->country);
    }

    public function getLanguage(): ?LanguageResource
    {
        if ($this->language_id == null) return null;

        return new LanguageResource($this->language);
    }
}
