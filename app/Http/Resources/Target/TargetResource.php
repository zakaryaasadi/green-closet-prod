<?php

namespace App\Http\Resources\Target;

use App\Models\Setting;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Setting
 **/
class TargetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'orders_count' => $this->orders_count,
            'weight_target' => $this->weight_target,
            'month' => $this->month,
        ];
    }
}
