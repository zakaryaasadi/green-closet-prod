<?php

namespace App\Http\Resources\Province;

use App\Http\Resources\Country\CountryResource;
use App\Models\Province;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Province
 **/
class ProvinceResource extends JsonResource
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
            'country' => $this->getCountryResource(),
            'meta' => $this->meta,
        ];
    }

    public function getCountryResource(): ?CountryResource
    {
        if (!$this->country) {
            return null;
        }

        return new CountryResource($this->country);
    }
}
