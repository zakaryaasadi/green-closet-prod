<?php

namespace App\Http\Resources\Neighborhood;

use App\Http\Resources\District\DistrictResource;
use App\Models\Neighborhood;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Neighborhood
 */
class NeighborhoodResource extends JsonResource
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
            'district' => $this->getDistrictResource(),
            'meta' => $this->meta,
        ];
    }

    public function getDistrictResource(): ?DistrictResource
    {
        if (!$this->district) {
            return null;
        }

        return new DistrictResource($this->district);
    }
}
