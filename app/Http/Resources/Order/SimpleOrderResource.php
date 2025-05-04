<?php

namespace App\Http\Resources\Order;

use App\Enums\OrderType;
use App\Helpers\AppHelper;
use App\Http\Resources\Address\SimpleAddressResource;
use App\Http\Resources\Item\SimpleItemResource;
use App\Http\Resources\User\SimpleUserResource;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Resources\Json\JsonResource;
use ipinfo\ipinfo\IPinfoException;

/**
 * @mixin Order
 **/
class SimpleOrderResource extends JsonResource
{
    /**
     * Transform the resource into a simple array.
     *
     * @throws IPinfoException
     */
    public function toArray($request): array
    {
        $location = $this->location;

        $settings = Setting::whereCountryId(AppHelper::getCoutnryForMobile())?->first() ?? Setting::where(['country_id' => null])->first();

        $language = AppHelper::getLanguageForMobile();

        if ($language == 'ar')
            $currency = $settings->currency_ar;
        else
            $currency = $settings->currency_en;

        return [
            'id' => $this->id,
            'country' => $this->country->name,
            'agent' => $this->getAgent(),
            'status' => $this->status,
            'date' => $this->created_at,
            'weight' => $this->weight,
            'value' => $this->type == OrderType::DONATION ? '0' : $this->value . '' . $currency,
            'type' => $this->type,
            'points' => $this->getOrderPoints(),
            'address' => $this->getAddress(),
            'association' => $this->getAssociation(),
            'location' => ['lat' => $location?->getLat(), 'lng' => $location?->getLng()],
            'failed_message' => $this->getMessage(),
            'total_time' => $this->total_time,
            'start_at' => $this->start_at,
            'ends_at' => $this->ends_at,
            'items' => $this->getItems(),
            'created_at' => $this->created_at,
            'start_task' => $this->start_task,
            'start_task_date' => $this->start_task ? $this->start_task->format('Y-m-d') : $this->start_task,
            'invoice' => $this->getInvoice(),
        ];
    }

    public function getMessage(): ?string
    {
        if ($this->failed_message)
            return $this->failed_message;

        elseif ($this->message)
            return $this->message->content;

        return null;
    }

    public function getInvoice(): ?string
    {
        $invoice = Invoice::whereOrderId($this->id)->first();

        return $invoice?->pdfUrl();

    }

    public function getOrderPoints(): ?int
    {
        return $this->point?->count;

    }

    public function getAddress(): SimpleAddressResource
    {
        return new SimpleAddressResource($this->address);
    }

    public function getAssociation(): ?string
    {
        return $this->association?->title;

    }

    public function getAgent(): ?SimpleUserResource
    {
        if ($this->agent == null) return null;

        return new SimpleUserResource($this->agent);
    }

    public function getItems()
    {
        return $this->items->map(function ($item) {
            return new SimpleItemResource($item);
        });
    }
}
