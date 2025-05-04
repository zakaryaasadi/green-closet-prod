<?php

namespace App\Http\Resources\User;

use App\Helpers\AppHelper;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Country\SimpleCountryResource;
use App\Http\Resources\Permission\SimplePermissionResource;
use App\Http\Resources\Role\RoleResource;
use App\Models\Country;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use ipinfo\ipinfo\IPinfoException;

/**
 * @mixin User
 **/
class MeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @throws IPinfoException
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
            'permissions' => $this->getPermissions(),
            'roles' => $this->getRoles(),
            'settings' => $this->getAgentSettings(),
            'access' => $this->getAccess(),
            'current_country' => $this->getCurrentCountry(),
        ];
    }

    /**
     * @throws IPinfoException
     */
    public function getCurrentCountry(): ?SimpleCountryResource
    {
        $country = AppHelper::getCoutnryForMobile();
        if (!$country) return null;

        return new SimpleCountryResource($country);
    }

    public function getAgentSettings(): ?array
    {
        return $this->agentSettings ? [
            'tasks_per_day' => $this->agentSettings?->tasks_per_day,
            'holiday' => $this->agentSettings?->holiday,
            'budget' => $this->agentSettings?->budget,
            'start_work' => $this->agentSettings?->start_work,
            'finish_work' => $this->agentSettings?->finish_work,
            'work_shift' => $this->agentSettings?->work_shift,
        ] : null;
    }

    public function getCountry(): array|CountryResource
    {
        if ($this->country == null) return [];

        return new CountryResource($this->country);
    }

    protected function getPermissions(): ?array
    {
        $collection = $this->getAllPermissions()->map(function ($permission) {
            return (new SimplePermissionResource($permission))->jsonSerialize();
        });

        return $collection->isNotEmpty() ? $collection->toArray() : null;
    }

    protected function getRoles(): Collection
    {
        $roles = [];
        $countries = Country::all();
        foreach ($countries as $country) {
            $userAccess = UserAccess::where('user_id', '=', $this->id)->where('country_id', '=', $country->id)->get();
            foreach ($userAccess as $access) {
                if ($access->role)
                    $roles[] = new RoleResource($access->role);
            }
        }

        return collect($roles)->unique();
    }

    public function getAccess(): ?array
    {
        $countries = Country::all();
        $permissions = [];
        $return = [];
        foreach ($countries as $country) {
            $userAccess = UserAccess::whereCountryId($country->id)->where('user_id', '=', $this->id)->get();
            foreach ($userAccess as $access) {
                $accessId = $access->id;
                $role = $access->role;
                foreach ($access->role->permissions()->get() as $permission) {
                    $permissions[] = new SimplePermissionResource($permission);
                }
                $countryArray = [
                    'access_id' => $accessId,
                    'role' => $role ?? new RoleResource($role),
                    'country' => new CountryResource($country),
                ];
                $return[] = array_merge($countryArray, ['permissions' => collect($permissions)->unique()]);
                $permissions = [];
            }
        }

        return count($return) > 0 ? $return : null;

    }
}
