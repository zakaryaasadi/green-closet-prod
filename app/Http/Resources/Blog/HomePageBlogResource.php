<?php

namespace App\Http\Resources\Blog;

use App\Models\Blog;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Blog
 **/
class HomePageBlogResource extends JsonResource
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
            'image' => $this->image,
        ];
    }
}
