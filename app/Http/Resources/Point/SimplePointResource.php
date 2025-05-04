<?php

namespace App\Http\Resources\Point;

use App\Helpers\AppHelper;
use App\Models\Point;
use Illuminate\Http\Resources\Json\JsonResource;
use ipinfo\ipinfo\IPinfoException;

/**
 * @mixin Point
 */
class SimplePointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @throws IPinfoException
     */
    public function toArray($request): array
    {
        $clientCountry = AppHelper::getCoutnryForMobile();

        return [
            'id' => $this->id,
            'user' => $this->getUser(),
            'order' => $this->getOrder(),
            'status' => $this->status,
            'ends_at' => $this->ends_at,
            'used' => $this->used,
            'count' => $this->count,
            'total' => $this->user->activePoints($clientCountry->id),
        ];
    }

    public function getOrder(): ?int
    {
        return $this->order?->id;
    }

    public function getUser()
    {
        return $this->user?->name;
    }

    public function getTotal()
    {
        return $this->user?->points?->sum('count');
    }
}
