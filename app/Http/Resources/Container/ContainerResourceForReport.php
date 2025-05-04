<?php

namespace App\Http\Resources\Container;

use App\Enums\ContainerStatus;
use App\Enums\ContainerType;
use App\Enums\DischargeShift;
use App\Helpers\AppHelper;
use App\Models\Container;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Container
 **/
class ContainerResourceForReport extends JsonResource
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
            'code' => $this->code,
            'association' => $this->getAssociation(),
            'team' => $this->getTranslateValue($locale, $this->team->meta, 'name', $this->team->name),
            'country' => $this->getTranslateValue($locale, $this->country->meta, 'name', $this->country->name),
            'province' => $this->getTranslateValue($locale, $this->province->meta, 'name', $this->province->name),
            'district' => $this->getTranslateValue($locale, $this->district->meta, 'name', $this->district->name),
            'neighborhood' => $this->getTranslateValue($locale, $this->neighborhood->meta, 'name', $this->neighborhood->name),
            'street' => $this->getTranslateValue($locale, $this->street->meta, 'name', $this->street->name),
            'discharge_shift' => DischargeShift::getKey($this->discharge_shift),
            'type' => ContainerType::getKey($this->type),
            'weight' => $this->getContainerDetails(),
            'status' => ContainerStatus::getKey($this->status),
        ];
    }

    public function getAssociation()
    {
        $locale = AppHelper::getLanguageForMobile();

        if (!$this->association) {
            return 'Kiswa Company';
        }

        return $this->association?->getTranslateValue($locale, $this->association->meta, 'title', $this->association->title);
    }

    protected function getContainerDetails()
    {
        if ($this->containerDetails)
            return $this->containerDetails()->sum('weight');

        return 0;
    }
}
