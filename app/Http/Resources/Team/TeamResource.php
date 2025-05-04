<?php

namespace App\Http\Resources\Team;

use App\Helpers\AppHelper;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\User\SimpleUserResource;
use App\Models\Team;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Team
 **/
class TeamResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $locale = AppHelper::getLanguageForMobile();

        return [
            'id' => $this->id,
            'name' => $this->getTranslateValue($locale, $this->meta, 'name', $this->name),
            'meta' => $this->meta,
            'agents' => $this->getAgents(),
            'country' => $this->getCountry($locale),
        ];
    }

    public function getCountry($locale): ?CountryResource
    {
        if ($this->country == null) return null;

        return new CountryResource($this->country, $locale);
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
}
