<?php

namespace App\Http\Resources\Team;

use App\Helpers\AppHelper;
use App\Models\Team;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Team
 **/
class SimpleTeamResource extends JsonResource
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
        ];
    }
}
