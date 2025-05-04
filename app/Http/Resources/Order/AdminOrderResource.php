<?php

namespace App\Http\Resources\Order;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Setting;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use ipinfo\ipinfo\IPinfoException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @mixin Order
 **/
class AdminOrderResource extends JsonResource
{
    use TranslateHelper;

    protected static Setting $settings;

    protected static string $language;

    public static function setAdditionalData($settings, $language): void
    {
        self::$settings = $settings;
        self::$language = $language;
    }

    public function __construct($resource)
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws IPinfoException
     */
    public function toArray($request): array
    {
        $location = $this->location;
        $settings = self::$settings;
        $language = self::$language;

        if ($language == 'ar')
            $currency = $settings->currency_ar;
        else
            $currency = $settings->currency_en;

        return [
            'id' => $this->id,
            'country' => $this->country ? [
                'name' => $this->getTranslateValue($language, $this->country->meta, 'name', $this->country->name),
                'meta' => $this->country->meta,
                'code' => $this->country->code,
            ] : null,
            'customer' => $this->customer ? [
                'id' => $this->customer->id,
                'email' => $this->customer->email ?? '',
                'phone' => $this->customer->phone ?? '',
                'name' => $this->customer->name ?? '',
                'image' => $this->customer->imageUrl(),
            ] : null,
            'address' => $this->address ? [
                'id' => $this->id,
                'province' => $this->province ? [
                    'id' => $this->id,
                    'name' => $this->getTranslateValue($language, $this->address->province->meta, 'name', $this->address->province->name),
                ] : null,
                'user' => $this->address->user?->name ?? '',
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
            'agent' => $this->agent ? [
                'id' => $this->agent->id,
                'email' => $this->agent->email,
                'phone' => $this->agent->phone,
                'has_verified_email' => $this->agent->hasVerifiedEmail(),
                'has_verified_phone' => $this->agent->hasVerifiedPhone(),
                'name' => $this->agent->name,
                'image' => $this->agent->imageUrl(),
                'language' => $this->agent->language,
            ] : null,
            'association' => $this->association ? [
                'id' => $this->association->id,
                'status' => $this->association->status,
                'priority' => $this->association->priority,
                'title' => $this->association->getTranslateValue($language, $this->association->meta, 'title', $this->association->title),
                'description' => $this->getTranslateValue($language, $this->association->meta, 'description', $this->association->description),
                'country' => $this->country != null ? $this->country->name : '',
                'url' => $this->association->url,
                'thumbnail' => $this->association->thumbnail,
            ] : null,
            'location' => ['lat' => $location?->getLat(), 'lng' => $location?->getLng()],
            'status' => $this->status,
            'type' => $this->type,
            'agent_payment' => $this->agent_payment,
            'failed_message' => $this->getMessage(),
            'weight' => $this->weight ?? 0.0,
            'value' => $this->value . '' . $currency,
            'total_time' => $this->total_time,
            'payment_remaining' => $this->payment_remaining,
            'start_at' => $this->start_at,
            'ends_at' => $this->ends_at,
            'platform' => $this->platform,
            'payment_status' => $this->payment_status,
            'image' => $this->imageUrl(),
            'invoice' => $this->getInvoice(),
            'created_at' => $this->created_at,
            'start_task' => $this->start_task,
            'start_task_date' => $this->start_task ? $this->start_task->format('Y-m-d') : $this->start_task,
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
}
