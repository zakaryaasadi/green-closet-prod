<?php

namespace App\Http\Resources\Country;

use App\Enums\MessageType;
use App\Helpers\AppHelper;
use App\Http\Resources\Association\SimpleAssociationResource;
use App\Http\Resources\Item\FullItemResource;
use App\Http\Resources\Province\SimpleProvinceResource;
use App\Models\Association;
use App\Models\Country;
use App\Models\Item;
use App\Models\Language;
use App\Models\Message;
use App\Models\Province;
use App\Models\Setting;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Country
 **/
class SimpleCountryWithItemResource extends JsonResource
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
        $thanksMessage = Message::where([
            'country_id' => $this->id,
            'language_id' => Language::whereCode(AppHelper::getLanguageForMobile())->first()->id,
            'type' => MessageType::THANKS_MESSAGE,
        ])->first() ?? Message::where([
            'country_id' => null,
            'language_id' => Language::whereCode(AppHelper::getLanguageForMobile())->first()->id,
            'type' => MessageType::THANKS_MESSAGE,
        ])->first();

        return [
            'id' => $this->id,
            'name' => $this->getTranslateValue($locale, $this->meta, 'name', $this->name),
            'code' => $this->code,
            'has_donation' => $settings == null ? 0 : $settings->has_donation == 1,
            'has_recycling' => $settings == null ? 0 : $settings->has_recycling == 1,
            'has_recycling_admin' => $settings == null ? 0 : $settings->has_recycling_admin == 1,
            'has_donation_admin' => $settings == null ? 0 : $settings->has_donation_admin == 1,
            'provinces' => $this->getProvince(),
            'items' => $this->getItems(),
            'associations' => $this->getAssociations(),
            'thanks_message' => $thanksMessage?->content,
            'code_number' => $this->code_number,
            'flag' => $this->flag,

        ];
    }

    public function getProvince(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return SimpleProvinceResource::collection(Province::whereCountryId($this->id)->get());
    }

    public function getItems(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return FullItemResource::collection(Item::whereCountryId($this->id)->get());
    }

    public function getAssociations(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return SimpleAssociationResource::collection(Association::whereCountryId($this->id)->get());
    }
}
