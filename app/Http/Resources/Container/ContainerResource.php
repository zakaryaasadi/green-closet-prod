<?php

namespace App\Http\Resources\Container;

use App\Http\Resources\Association\SimpleAssociationResource;
use App\Http\Resources\Country\SimpleCountryResource;
use App\Http\Resources\District\SimpleDistrictResource;
use App\Http\Resources\Neighborhood\SimpleNeighborhoodResource;
use App\Http\Resources\Province\SimpleProvinceResource;
use App\Http\Resources\Street\SimpleStreetResource;
use App\Http\Resources\Team\SimpleTeamResource;
use App\Models\Container;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Container
 **/
class ContainerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $location = $this->location;

        return [
            'id' => $this->id,
            'code' => $this->code,
            'association' => $this->getSimpleAssociationResource(),
            'team' => $this->getSimpleTeamResource(),
            'country' => $this->getSimpleCountryResource(),
            'province' => $this->getSimpleProvinceResource(),
            'district' => $this->getSimpleDistrictResource(),
            'neighborhood' => $this->getSimpleNeighborhoodResource(),
            'street' => $this->getSimpleStreetResource(),
            'discharge_shift' => $this->discharge_shift,
            'type' => $this->type,
            'weight' => $this->getContainerDetails(),
            'status' => $this->status,
            'location' => ['lat' => $location->getLat(), 'lng' => $location->getLng()],
            'location_description' => $this->location_description,
            'last_update' => $this->updated_at,
        ];
    }

    protected function getSimpleAssociationResource(): ?array
    {
        if (!$this->association)
            return null;
        $association = new SimpleAssociationResource($this->association);

        return $association->jsonSerialize();
    }

    protected function getSimpleCountryResource(): ?array
    {
        if (!$this->country)
            return null;
        $country = new SimpleCountryResource($this->country);

        return $country->jsonSerialize();
    }

    protected function getSimpleProvinceResource(): ?array
    {
        if (!$this->province)
            return null;
        $province = new SimpleProvinceResource($this->province);

        return $province->jsonSerialize();
    }

    protected function getSimpleDistrictResource(): ?array
    {
        if (!$this->district)
            return null;
        $district = new SimpleDistrictResource($this->district);

        return $district->jsonSerialize();
    }

    protected function getSimpleNeighborhoodResource(): ?array
    {
        if (!$this->neighborhood)
            return null;
        $neighborhood = new SimpleNeighborhoodResource($this->neighborhood);

        return $neighborhood->jsonSerialize();
    }

    protected function getSimpleStreetResource(): ?array
    {
        if (!$this->street)
            return null;
        $street = new SimpleStreetResource($this->street);

        return $street->jsonSerialize();
    }

    protected function getSimpleTeamResource(): ?array
    {
        if (!$this->team)
            return null;
        $team = new SimpleTeamResource($this->team);

        return $team->jsonSerialize();
    }

    protected function getContainerDetails()
    {
        if ($this->containerDetails)
            return $this->containerDetails()->sum('weight');

        return 0;
    }
}
