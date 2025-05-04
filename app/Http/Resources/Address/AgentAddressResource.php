<?php

namespace App\Http\Resources\Address;

use App\Http\Resources\Province\SimpleProvinceResource;
use App\Models\Address;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Address
 */
class AgentAddressResource extends JsonResource
{
    public function toArray($request): array
    {
        $location = $this->location;

        return [
            'id' => $this->id,
            'province' => $this->getProvinceResource(),
            'apartment_number' => $this->apartment_number,
            'floor_number' => $this->floor_number,
            'building' => $this->building,
            'location' => [
                'title' => $this->location_title,
                'province' => $this->location_province,
                'lat' => $location->getLat(),
                'lng' => $location->getLng(),
            ],
        ];
    }

    public function getProvinceResource(): ?SimpleProvinceResource
    {
        if (!$this->province)
            return null;

        return new SimpleProvinceResource($this->province);
    }
}
