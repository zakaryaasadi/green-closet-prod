<?php

namespace App\Http\Resources\Partner;

use App\Helpers\AppHelper;
use App\Models\Partner;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Partner
 **/
class SimplePartnerResource extends JsonResource
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
            'name' => $this->getTranslateValue($locale, $this->meta, 'name', $this->name),
            'description' => $this->getTranslateValue($locale, $this->meta, 'description', $this->description),
            'url' => $this->url,
            'image' => $this->image_path,
            'country' => $this->country != null ? $this->country->name : '',
        ];
    }
}
