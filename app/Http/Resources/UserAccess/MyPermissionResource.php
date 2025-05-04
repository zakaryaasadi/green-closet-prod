<?php

namespace App\Http\Resources\UserAccess;

use App\Http\Resources\Permission\SimplePermissionResource;
use App\Models\UserAccess;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserAccess
 */
class MyPermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'country' => $this->country?->name,
            'type' => $this->access_level,
            'permissions' => $this->getPermissionsResource(),
        ];
    }

    protected function getPermissionsResource(): ?array
    {
        $collection = $this->getAllPermissions()->map(function ($permission) {
            return (new SimplePermissionResource($permission))->jsonSerialize();
        });

        return $collection->isNotEmpty() ? $collection->toArray() : null;
    }
}
