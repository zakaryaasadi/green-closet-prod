<?php

namespace App\Http\Resources\Container;

use App\Helpers\AppHelper;
use App\Models\Container;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Container
 **/
class SimpleContainerResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $locale = AppHelper::getLanguageForMobile();

        $location = $this->location;

        return [
            'id' => $this->id,
            'code' => $this->code,
            'association' => $this->getTranslateValue($locale, $this->association?->meta, 'title', $this->association?->title),
            'team' => $this->getTranslateValue($locale, $this->team?->meta, 'name', $this->team?->name),
            'country' => $this->getTranslateValue($locale, $this->country?->meta, 'name', $this->country?->name),
            'province' => $this->getTranslateValue($locale, $this->province?->meta, 'name', $this->province?->name),
            'district' => $this->getTranslateValue($locale, $this->district?->meta, 'name', $this->district?->name),
            'neighborhood' => $this->getTranslateValue($locale, $this->neighborhood?->meta, 'name', $this->neighborhood?->name),
            'street' => $this->getTranslateValue($locale, $this->street?->meta, 'name', $this->street?->name),
            'discharge_shift' => $this->discharge_shift,
            'type' => $this->type,
            'status' => $this->status,
            'location' => ['lat' => $location->getLat(), 'lng' => $location->getLng()],
            'location_description' => $this->location_description,
        ];
    }
}
