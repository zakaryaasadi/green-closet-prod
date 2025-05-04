<?php

namespace App\Http\Resources\News;

use App\Helpers\AppHelper;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\MediaModel\MediaModelResource;
use App\Models\News;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin News
 **/
class NewsResource extends JsonResource
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
            'slug' => $this->slug,
            'display_order' => $this->display_order,
            'meta_tags' => $this->meta_tags,
            'meta_tags_arabic' => $this->meta_tags_arabic,
            'country' => $this->getCountryResource(),
            'meta' => $this->meta,
            'link' => $this->link,
            'thumbnail' => $this->thumbnail,
            'images' => $this->getImages(),
            'scripts' => $this->scripts,
            'scripts_arabic' => $this->scripts_arabic,
        ];
    }

    public function getCountryResource(): ?CountryResource
    {
        if ($this->country == null) return null;

        return new CountryResource($this->country);
    }

    public function getImages()
    {
        return MediaModelResource::collection($this->images);
    }
}
