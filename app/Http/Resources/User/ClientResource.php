<?php

namespace App\Http\Resources\User;

use App\Enums\OrderStatus;
use App\Http\Resources\Country\CountryResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 **/
class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'phone' => $this->phone,
            'has_verified_email' => $this->hasVerifiedEmail(),
            'has_verified_phone' => $this->hasVerifiedPhone(),
            'name' => $this->name,
            'image' => $this->imageUrl(),
            'country' => $this->getCountry(),
            'language' => $this->language,
            'status' => $this->status,
            'type' => $this->type,
            'orders' => $this->getOrders(),
        ];
    }

    public function getCountry(): array|CountryResource
    {
        if ($this->country == null) return [];

        return new CountryResource($this->country);
    }

    public function getOrders(): array
    {
        $orders = $this->orders();

        return [
            'total' => $orders->clone()->count(),
            'created' => $orders->clone()->where('status', '=', OrderStatus::CREATED)->count(),
            'assigned' => $orders->clone()->where('status', '=', OrderStatus::ASSIGNED)->count(),
            'accepted' => $orders->clone()->where('status', '=', OrderStatus::ACCEPTED)->count(),
            'declined' => $orders->clone()->where('status', '=', OrderStatus::DECLINE)->count(),
            'delivering' => $orders->clone()->where('status', '=', OrderStatus::DELIVERING)->count(),
            'canceled' => $orders->clone()->where('status', '=', OrderStatus::CANCEL)->count(),
            'failed' => $orders->clone()->where('status', '=', OrderStatus::FAILED)->count(),
            'successful' => $orders->clone()->where('status', '=', OrderStatus::SUCCESSFUL)->count(),
        ];
    }
}
