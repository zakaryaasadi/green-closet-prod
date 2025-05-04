<?php

namespace App\Http\Resources\UserAccess;

use App\Http\Resources\Country\SimpleCountryResource;
use App\Models\UserAccess;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserAccess
 */
class SimpleAccessLevelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'country' => $this->getSimpleCountry(),
            'access_level' => $this->access_level,
        ];
    }

    public function getSimpleCountry(): ?SimpleCountryResource
    {
        return $this->country ? new SimpleCountryResource($this->country) : null;
    }
}
