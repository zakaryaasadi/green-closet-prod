<?php

namespace App\Http\Resources\Event;

use App\Helpers\AppHelper;
use App\Http\Resources\Country\SimpleCountryResource;
use App\Http\Resources\MediaModel\MediaModelResource;
use App\Models\Event;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Event
 **/
class EventResource extends JsonResource
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
            'date' => $this->date,
            'meta' => $this->meta,
            'thumbnail' => $this->thumbnail,
            'images' => $this->getImages(),
            'country' => $this->getCountryResource(),
        ];
    }

    public function getCountryResource(): ?SimpleCountryResource
    {
        if ($this->country == null) return null;

        return new SimpleCountryResource($this->country);
    }

    public function getImages()
    {
        return MediaModelResource::collection($this->images);
    }
}
