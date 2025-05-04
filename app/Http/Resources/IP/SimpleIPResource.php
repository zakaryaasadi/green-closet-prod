<?php

namespace App\Http\Resources\IP;

use App\Models\IP;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IP
 **/
class SimpleIPResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'ip_address' => $this->ip_address,
            'status' => $this->status,
        ];
    }
}
