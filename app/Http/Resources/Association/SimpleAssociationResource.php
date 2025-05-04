<?php

namespace App\Http\Resources\Association;

use App\Helpers\AppHelper;
use App\Http\Resources\MediaModel\SimpleMediaModelResource;
use App\Models\Association;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Association
 **/
class SimpleAssociationResource extends JsonResource
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
            'status' => $this->status,
            'priority' => $this->priority,
            'title' => $this->getTranslateValue($locale, $this->meta, 'title', $this->title),
            'description' => $this->getTranslateValue($locale, $this->meta, 'description', $this->description),
            'country' => $this->country != null ? $this->country->name : '',
            'url' => $this->url,
            'thumbnail' => $this->thumbnail,
            'images' => $this->getImages(),
        ];
    }

    public function getImages(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return SimpleMediaModelResource::collection($this->images);
    }
}
