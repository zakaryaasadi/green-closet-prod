<?php

namespace App\Http\Resources\Association;

use App\Helpers\AppHelper;
use App\Http\Resources\Country\CountryResource;
use App\Http\Resources\MediaModel\MediaModelResource;
use App\Http\Resources\User\SimpleUserResource;
use App\Models\Association;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Association
 **/
class AssociationResource extends JsonResource
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
            'status' => $this->status,
            'priority' => $this->priority,
            'title' => $this->getTranslateValue($locale, $this->meta, 'title', $this->title),
            'admin' => $this->getUserResource(),
            'description' => $this->getTranslateValue($locale, $this->meta, 'description', $this->description),
            'country' => $this->getCountryResource(),
            'url' => $this->url,
            'meta' => $this->meta,
            'IBAN' => $this->IBAN,
            'swift_code' => $this->swift_code,
            'account_number' => $this->account_number,
            'thumbnail' => $this->thumbnail,
            'images' => $this->getImages(),
        ];
    }

    public function getCountryResource(): ?CountryResource
    {
        if ($this->country == null) return null;

        return new CountryResource($this->country);
    }

    public function getUserResource(): SimpleUserResource
    {
        return new SimpleUserResource($this->admin);
    }

    public function getImages()
    {
        return MediaModelResource::collection($this->images);
    }
}
