<?php

namespace App\Http\Resources\Event;

use App\Helpers\AppHelper;
use App\Http\Resources\MediaModel\SimpleMediaModelResource;
use App\Models\Event;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Event
 **/
class SimpleEventResource extends JsonResource
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
            'thumbnail' => $this->thumbnail,
            'images' => $this->getImages(),
            'date' => $this->date,
            'country' => $this->country != null ? $this->country->name : '',
        ];
    }

    public function getImages()
    {
        return SimpleMediaModelResource::collection($this->images);
    }
}
