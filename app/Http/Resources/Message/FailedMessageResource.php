<?php

namespace App\Http\Resources\Message;

use App\Models\Message;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Message
 **/
class FailedMessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'content' => $this->content,
        ];
    }
}
