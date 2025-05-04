<?php

namespace App\Http\Resources\Page;

use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Language\LanguageResource;
use App\Http\Resources\Section\SectionResource;
use App\Models\Page;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Page
 **/
class PageResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'is_home' => $this->is_home,
            'slug' => $this->slug,
            'meta_tags' => $this->meta_tags,
            'meta_tags_arabic' => $this->meta_tags_arabic,
            'custom_styles' => $this->custom_styles,
            'custom_scripts' => $this->custom_scripts,
            'custom_scripts_arabic' => $this->custom_scripts_arabic,
            'default_page_title' => $this->default_page_title,
            'country' => $this->getCountry(),
            'language' => $this->getLanguage(),
            'sections' => $this->getSections(),
        ];
    }

    public function getSections(): array
    {
        $sectionsResource = [];
        $sections = $this->sections()->get();
        foreach ($sections as $section) {
            $sectionsResource[] = new SectionResource($section);
        }

        return $sectionsResource;

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
