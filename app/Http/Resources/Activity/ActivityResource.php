<?php

namespace App\Http\Resources\Activity;

use App\Http\Resources\User\SimpleUserResource;
use App\Models\Activity;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Activity
 **/
class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'causer' => $this->getSimpleUserResource(),
            'subject' => class_basename($this->subject),
            'description' => $this->description,
            'properties' => $this->properties,
            'date' => $this->created_at,
        ];
    }

    public function getSimpleUserResource(): ?SimpleUserResource
    {
        if (!$this->causer)
            return null;

        return new SimpleUserResource($this->causer);
    }
}
