<?php

namespace App\Http\Resources\Street;

use App\Http\Resources\Neighborhood\NeighborhoodResource;
use App\Models\Street;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Street
 */
class StreetResource extends JsonResource
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
            'neighborhood' => $this->getNeighborhoodResource(),
            'meta' => $this->meta,
        ];
    }

    public function getNeighborhoodResource(): ?NeighborhoodResource
    {
        if (!$this->neighborhood) {
            return null;
        }

        return new NeighborhoodResource($this->neighborhood);
    }
}
