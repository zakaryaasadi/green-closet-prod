<?php

namespace App\Http\Resources\Point;


use App\Http\Resources\Country\SimpleCountryResource;
use App\Http\Resources\Order\SimpleOrderResource;
use App\Http\Resources\User\SimpleUserResource;
use App\Models\Point;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Point
 **/
class PointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->getUserResource(),
            'country' => $this->getCountryResource(),
            'order' => $this->getOrderResource(),
            'status' => $this->status,
            'ends_at' => $this->ends_at,
            'count' => $this->count,
        ];
    }

    public function getUserResource(): SimpleUserResource
    {
        return new SimpleUserResource($this->user);
    }

    public function getOrderResource(): SimpleOrderResource
    {
        return new SimpleOrderResource($this->order);
    }

    public function getCountryResource(): SimpleCountryResource
    {
        return new SimpleCountryResource($this->country);
    }
}
