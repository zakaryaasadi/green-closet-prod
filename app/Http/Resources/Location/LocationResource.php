<?php

namespace App\Http\Resources\Location;

use App\Http\Resources\Province\SimpleProvinceResource;
use App\Http\Resources\Team\SimpleTeamResource;
use App\Http\Resources\User\SimpleUserResource;
use App\Models\Location;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Location
 **/
class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'color' => $this->color,
            'province' => $this->getProvinceResource(),
            'team' => $this->getTeam(),
            'area' => $this->getArea(),
            'agents' => $this->getAgents(),
        ];
    }

    public function getProvinceResource(): ?SimpleProvinceResource
    {
        if (!$this->province)
            return null;

        return new SimpleProvinceResource($this->province);
    }

    /**
     * @return array
     */
    public function getArea(): array
    {
        $result = [];
        $points = $this->area->getLineStrings()[0]->getPoints();
        foreach ($points as $point)
            $result[] = ['lat' => $point->getLat(), 'lng' => $point->getLng()];

        return $result;
    }

    public function getAgents(): array
    {
        $agentsResource = [];
        $agents = $this->agents()->get();
        foreach ($agents as $agent) {
            $agentsResource[] = new SimpleUserResource($agent);
        }

        return $agentsResource;

    }

    public function getTeam(): SimpleTeamResource
    {
        return new SimpleTeamResource($this->team);
    }
}
