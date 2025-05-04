<?php

namespace App\Http\Resources\Order;

use App\Enums\MessageType;
use App\Helpers\AppHelper;
use App\Http\Resources\Message\FailedMessageResource;
use App\Models\AgentSettings;
use App\Models\Message;
use App\Models\Order;
use App\Models\Setting;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Order
 */
class AgentOrderResource extends JsonResource
{
    use TranslateHelper;

    public function toArray($request): array
    {
        $locale = AppHelper::getLanguageForMobile();
        $settings = Setting::whereCountryId($this->id)->first();
        if ($settings == null) {
            $settings = Setting::whereCountryId(null)->first();
        }
        $location = $this->location;
        $customer = $this->customer;

        return [
            'order' => [
                'id' => $this->id,
                'location' => ['lat' => $location?->getLat(), 'lng' => $location?->getLng()],
                'status' => $this->status,
                'type' => $this->type,
                'start_task' => $this->start_task,
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
                'weight' => $this->weight ?? 0.0,
                'address' => $this->address ? [
                    'id' => $this->address->id,
                    'province' => $this->address->province ? [
                        'id' => $this->address->province->id,
                        'name' => $this->getTranslateValue($locale, $this->address->province->meta, 'name', $this->address->province->name),
                    ] : null,
                    'apartment_number' => $this->address->apartment_number,
                    'floor_number' => $this->address->floor_number,
                    'building' => $this->address->building,
                    'location' => [
                        'title' => $this->address->location_title,
                        'province' => $this->address->location_province,
                        'lat' => $this->address->location->getLat(),
                        'lng' => $this->address->location->getLng(),
                    ],
                ] : null,
                'items' => $this->getItems($locale),
                'country' => $this->country ? [
                    'id' => $this->id,
                    'name' => $this->getTranslateValue($locale, $this->country->meta, 'name', $this->country->name),
                    'meta' => $this->country->meta,
                    'code' => $this->country->code,
                    'flag' => $this->country->flag,
                    'code_number' => $this->country->code_number,
                    'status' => $this->country->status,
                    'has_donation' => $settings == null ? 0 : $settings->has_donation == 1,
                    'has_recycling' => $settings == null ? 0 : $settings->has_recycling == 1,
                    'has_donation_admin' => $settings == null ? 0 : $settings->has_donation_admin == 1,
                    'has_recycling_admin' => $settings == null ? 0 : $settings->has_recycling_admin == 1,
                ] : null,
                'created_at' => $this->created_at,
                'association_title' => $this->association ?
                    $this->getTranslateValue($locale, $this->association->meta, 'title', $this->association->title) : null,
            ],
            'failed_messages' => $this->getMessagesResourceByType(MessageType::FAILED_MESSAGE),
            'cancel_messages' => $this->getMessagesResourceByType(MessageType::FAILED_MESSAGE),
            'settings' => $this->getSettings(),
        ];
    }

    public function getItems($locale): ?array
    {
        if (is_null($this->items)) return null;

        $agentItems = [];
        foreach ($this->items as $item) {
            $agentItems[] = [
                'id' => $item->id,
                'title' => $this->getTranslateValue($locale, $item->meta, 'title', $item->title),
                'image' => $item->image_path,
                'price_per_kg' => $item->price_per_kg,
                'weight' => $item->pivot ? $item->pivot->weight : null,
            ];
        }

        return $agentItems;
    }

    public function getMessagesResourceByType($type): AnonymousResourceCollection
    {
        return FailedMessageResource::collection(Message::where([
            'country_id' => $this->country_id,
            'type' => $type,
        ])->get());
    }

    public function getSettings(): ?array
    {
        $settings = AgentSettings::whereAgentId($this->agent_id)->first();
        if ($settings)
            return [
                'tasks_per_day' => $settings?->tasks_per_day,
                'holiday' => $settings?->holiday,
                'budget' => $settings?->budget,
                'start_work' => $settings?->start_work,
                'finish_work' => $settings?->finish_work,
                'work_shift' => $settings?->work_shift,
            ];
        else
            return null;
    }
}
