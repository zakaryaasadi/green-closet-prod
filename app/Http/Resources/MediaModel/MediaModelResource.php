<?php

namespace App\Http\Resources\MediaModel;

use App\Http\Resources\Country\CountryResource;
use App\Models\MediaModel;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MediaModel
 **/
class MediaModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'media' => $this->mediaUrl(),
            'tag' => $this->tag,
            'country' => $this->getCountryResource(),
            'type' => $this->type,
        ];
    }

    public function getCountryResource(): ?CountryResource
    {
        if ($this->country == null) return null;

        return new CountryResource($this->country);
    }
}
