<?php

namespace App\Http\Resources\Blog;

use App\Helpers\AppHelper;
use App\Http\Resources\Country\CountryResource;
use App\Models\Blog;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Blog
 **/
class BlogResource extends JsonResource
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
            'description' => $this->getTranslateValue($locale, $this->meta, 'description', $this->description),
            'meta_tags' => $this->meta_tags,
            'meta_tags_arabic' => $this->meta_tags_arabic,
            'slug' => $this->slug,
            'country' => $this->getCountryResource(),
            'meta' => $this->meta,
            'image' => $this->image,
        ];
    }

    public function getCountryResource(): ?CountryResource
    {
        if ($this->country == null) return null;

        return new CountryResource($this->country);
    }
}
