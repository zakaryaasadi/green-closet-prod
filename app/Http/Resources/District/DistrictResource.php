<?php

namespace App\Http\Resources\District;

use App\Http\Resources\Province\ProvinceResource;
use App\Models\District;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin District
 **/
class DistrictResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'province' => $this->getProvinceResource(),
            'meta' => $this->meta,
        ];
    }

    public function getProvinceResource(): ?ProvinceResource
    {
        if (!$this->province)
            return null;

        return new ProvinceResource($this->province);
    }
}
