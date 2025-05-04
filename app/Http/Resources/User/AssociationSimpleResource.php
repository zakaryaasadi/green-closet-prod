<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Container\ContainerResource;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Expense\ExpenseResource;
use App\Models\Association;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 **/
class AssociationSimpleResource extends JsonResource
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
            'containers' => $this->getContainers(),
            'expenses' => $this->getExpenses(),
        ];
    }

    public function getCountry(): array|CountryResource
    {
        if ($this->country == null) return [];

        return new CountryResource($this->country);
    }

    public function getContainers(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection|array
    {
        $association = Association::whereUserId($this->id)->first();
        if ($association->containers != null) {
            if ($association && $association->containers) {
                return ContainerResource::collection($association->containers);
            }
        }

        return [];
    }

    public function getExpenses(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection|array
    {
        $association = Association::whereUserId($this->id)->first();
        if ($association && $association->expense) {
            return ExpenseResource::collection($association->expense);
        }

        return [];

    }
}
