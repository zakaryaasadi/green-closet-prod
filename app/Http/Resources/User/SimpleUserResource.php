<?php

namespace App\Http\Resources\User;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 **/
class SimpleUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'email' => $this->email ?? '',
            'phone' => $this->phone ?? '',
            'name' => $this->name ?? '',
            'image' => $this->imageUrl(),
        ];
    }
}
