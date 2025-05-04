<?php

namespace App\Http\Resources\Message;

use App\Http\Resources\Country\SimpleCountryResource;
use App\Http\Resources\Language\LanguageResource;
use App\Models\Message;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Message
 **/
class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'content' => $this->content,
            'type' => $this->type,
            'country' => $this->getSimpleCountryResource(),
            'language' => $this->getLanguageResource(),
        ];
    }

    public function getSimpleCountryResource(): array|SimpleCountryResource
    {
        return new SimpleCountryResource($this->country);
    }

    public function getLanguageResource(): array|LanguageResource
    {
        return new LanguageResource($this->language);
    }
}
