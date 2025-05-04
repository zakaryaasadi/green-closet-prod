<?php

namespace App\Http\Resources\MediaModel;

use App\Models\MediaModel;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin MediaModel
 **/
class SimpleMediaModelResource extends JsonResource
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
        ];
    }
}
