<?php

namespace App\Http\Resources\Activity;

use App\Http\Resources\Association\SimpleAssociationResource;
use App\Http\Resources\District\SimpleDistrictResource;
use App\Http\Resources\Neighborhood\SimpleNeighborhoodResource;
use App\Http\Resources\Province\SimpleProvinceResource;
use App\Http\Resources\Street\SimpleStreetResource;
use App\Http\Resources\Team\SimpleTeamResource;
use App\Http\Resources\User\SimpleUserResource;
use App\Models\Activity;
use App\Models\Association;
use App\Models\District;
use App\Models\Neighborhood;
use App\Models\Province;
use App\Models\Street;
use App\Models\Team;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Activity
 **/
class ContainerLogActivityResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'causer' => $this->getSimpleUserResource(),
            'action' => $this->description,
            'old' => $this->getOldStatus(),
            'current' => $this->getCurrentStatus(),
            'date' => $this->created_at,
        ];
    }

    public function getOldStatus(): ?array
    {
        $properties = collect($this->properties);
        if ($properties->has('old')) {
            $olds = [];
            $old = collect($properties->get('old'));
            foreach ($old->keys() as $key) {
                $value = $old->get($key);
                if ($key == 'association_id') {
                    $key = 'association';
                    $value = new SimpleAssociationResource(Association::whereId($old->get('association_id'))->first());
                }
                if ($key == 'team_id') {
                    $key = 'team';
                    $value = new SimpleTeamResource(Team::whereId($old->get('team_id'))->first());
                }
                if ($key == 'province_id') {
                    $key = 'province';
                    $value = new SimpleProvinceResource(Province::whereId($old->get('province_id'))->first());
                }
                if ($key == 'district_id') {
                    $key = 'district';
                    $value = new SimpleDistrictResource(District::whereId($old->get('district_id'))->first());
                }
                if ($key == 'neighborhood_id') {
                    $key = 'neighborhood';
                    $value = new SimpleNeighborhoodResource(Neighborhood::whereId($old->get('neighborhood_id'))->first());
                }

                if ($key == 'street_id') {
                    $key = 'street';
                    $value = new SimpleStreetResource(Street::whereId($old->get('street_id'))->first());
                }
                $olds[] = [
                    'key' => $key,
                    'value' => $value,
                ];
            }

            return $olds;
        }
        else
            return null;
    }

    public function getCurrentStatus(): ?array
    {
        $properties = collect($this->properties);
        if ($properties->has('attributes')) {
            $currents = [];
            $current = collect($properties->get('attributes'));
            foreach ($current->keys() as $key) {
                $value = $current->get($key);
                if ($key == 'association_id') {
                    $key = 'association';
                    $value = new SimpleAssociationResource(Association::whereId($current->get('association_id'))->first());
                }
                if ($key == 'team_id') {
                    $key = 'team';
                    $value = new SimpleTeamResource(Team::whereId($current->get('team_id'))->first());
                }
                if ($key == 'province_id') {
                    $key = 'province';
                    $value = new SimpleProvinceResource(Province::whereId($current->get('province_id'))->first());
                }
                if ($key == 'district_id') {
                    $key = 'district';
                    $value = new SimpleDistrictResource(District::whereId($current->get('district_id'))->first());
                }
                if ($key == 'neighborhood_id') {
                    $key = 'neighborhood';
                    $value = new SimpleNeighborhoodResource(Neighborhood::whereId($current->get('neighborhood_id'))->first());
                }

                if ($key == 'street_id') {
                    $key = 'street';
                    $value = new SimpleStreetResource(Street::whereId($current->get('street_id'))->first());
                }
                $currents[] = [
                    'key' => $key,
                    'value' => $value,
                ];
            }

            return $currents;
        }
        else
            return null;
    }

    public function getSimpleUserResource(): ?SimpleUserResource
    {
        if (!$this->causer)
            return null;

        return new SimpleUserResource($this->causer);
    }
}
