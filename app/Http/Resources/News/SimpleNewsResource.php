<?php

namespace App\Http\Resources\News;

use App\Helpers\AppHelper;
use App\Http\Resources\MediaModel\SimpleMediaModelResource;
use App\Models\News;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin News
 **/
class SimpleNewsResource extends JsonResource
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
            'link' => $this->link,
            'title' => $this->getTranslateValue($locale, $this->meta, 'title', $this->title),
            'description' => $this->getTranslateValue($locale, $this->meta, 'description', $this->description),
            'display_order' => $this->display_order,
            'thumbnail' => $this->thumbnail,
            'images' => $this->getImages(),
            'country' => $this->country != null ? $this->country->name : '',
        ];
    }

    public function getImages()
    {
        return SimpleMediaModelResource::collection($this->images);
    }
}
