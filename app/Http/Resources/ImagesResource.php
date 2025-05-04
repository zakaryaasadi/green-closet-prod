<?php

namespace App\Http\Resources;

use App\Models\Media;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Media
 */
class ImagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getCustomProperty('name'),
            'file_name' => $this->file_name,
            'extension' => $this->getTypeFromMime(),
            'size' => $this->size,
            'url' => $this->getUrl(),
        ];
    }
}
