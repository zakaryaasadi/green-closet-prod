<?php

namespace App\Http\Resources\Neighborhood;

use App\Helpers\AppHelper;
use App\Models\Neighborhood;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Neighborhood
 */
class SimpleNeighborhoodResource extends JsonResource
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
        ];
    }
}
