<?php

namespace App\Http\Resources\UserAccess;

use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Permission\SimplePermissionResource;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\User\SimpleUserResource;
use App\Models\UserAccess;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserAccess
 */
class UserAccessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => $this->getUser(),
            'country' => $this->getCountry(),
            'role' => $this->getRule(),
            'permissions' => $this->getPermissions(),
        ];
    }

    public function getUser(): SimpleUserResource
    {
        return new SimpleUserResource($this->user);
    }

    public function getCountry(): CountryResource
    {
        return new CountryResource($this->country);
    }

    protected function getRule(): ?array
    {
        return (new RoleResource($this->role))->jsonSerialize();
    }

    protected function getPermissions(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return SimplePermissionResource::collection($this->role->permissions()->get());
    }
}
