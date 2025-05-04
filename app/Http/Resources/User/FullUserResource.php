<?php

namespace App\Http\Resources\User;


use App\Helpers\AppHelper;
use App\Http\Resources\Country\CountryResource;
use App\Models\Country;
use App\Models\User;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 **/
class FullUserResource extends JsonResource
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
            'settings' => $this->getSettings(),
            'team_name' => $this->getTeam($locale),
            'last_login_at' => $this->last_login_at,
            'roles_names' => $this->getRolesNames(),

        ];
    }

    public function getRolesNames(): array
    {
        $return = [];
        $country_code = request()->header('country');
        $country = Country::whereCode($country_code)?->first();
        if ($country != null) {
            $userAccess = $this->userAccess()->where('country_id', $country->id)->get();
            foreach ($userAccess as $access) {
                $return[] = [
                    $access->role->name,
                ];
            }
        }

        return $return;
    }

    public function getCountry(): array|CountryResource
    {
        if ($this->country == null) return [];

        return new CountryResource($this->country);
    }

    public function getSettings(): ?array
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

    public function getTeam($locale)
    {
        if ($this->team == null) return '';
        $team = $this->team;

        return $this->getTranslateValue($locale, $team->meta, 'name', $team->name);
    }
}
