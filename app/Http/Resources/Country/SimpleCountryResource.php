<?php

namespace App\Http\Resources\Country;

use App\Enums\ActiveStatus;
use App\Helpers\AppHelper;
use App\Http\Resources\Association\SimpleAssociationResource;
use App\Http\Resources\Province\SimpleProvinceResource;
use App\Models\Association;
use App\Models\Country;
use App\Models\Province;
use App\Models\Setting;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Country
 **/
class SimpleCountryResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        $locale = AppHelper::getLanguageForMobile();
        $settings = Setting::whereCountryId($this->id)->first();
        if ($settings == null) {
            $settings = Setting::whereCountryId(null)->first();
        }

        return [
            'id' => $this->id,
            'name' => $this->getTranslateValue($locale, $this->meta, 'name', $this->name),
            'code' => $this->code,
            'has_donation' => $settings == null ? 0 : $settings->has_donation == 1,
            'has_recycling' => $settings == null ? 0 : $settings->has_recycling == 1,
            'has_donation_admin' => $settings == null ? 0 : $settings->has_donation_admin == 1,
            'has_recycling_admin' => $settings == null ? 0 : $settings->has_recycling_admin == 1,
            'provinces' => $this->getProvince(),
            'associations' => $this->getAssociations(),
            'code_number' => $this->code_number,
            'flag' => $this->flag,

        ];
    }

    public function getProvince(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return SimpleProvinceResource::collection(Province::whereCountryId($this->id)->get());
    }

    public function getAssociations(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return SimpleAssociationResource::collection(Association::where([
            'country_id' => $this->id,
            'status' => ActiveStatus::ACTIVE,
        ])->orderBy('priority')->get()
        );
    }
}
