<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\Team\SimpleTeamResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 **/
class SimpleAgentResource extends JsonResource
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
            'settings' => $this->getAgentSettings(),
            'team' => $this->getTeam(),
        ];
    }

    public function getCountry(): array|CountryResource
    {
        if ($this->country == null) return [];

        return new CountryResource($this->country);
    }

    public function getTeam(): array|SimpleTeamResource
    {
        if ($this->team == null) return [];

        return new SimpleTeamResource($this->team);
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
}
