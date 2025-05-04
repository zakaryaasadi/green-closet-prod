<?php

namespace App\Http\Resources\News;

use App\Models\News;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin News
 **/
class HomePageNewsResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $locale = app()->getLocale();

        return [
            'title' => $this->getTranslateValue($locale, $this->meta, 'title', $this->title),
            'description' => $this->getTranslateValue($locale, $this->meta, 'description', $this->description),
            'display_order' => $this->display_order,
            'image' => $this->image,
            'link' => $this->link,
        ];
    }
}
