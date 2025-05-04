<?php

namespace App\Http\Resources\Order;

use App\Helpers\AppHelper;
use App\Models\Order;
use App\Models\Setting;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use ipinfo\ipinfo\IPinfoException;

/**
 * @mixin Order
 **/
class OrderResourceForExport extends JsonResource
{
    use TranslateHelper;

    public Setting|null $settings;

    public string|null $language;

    public function __construct($resource, $settings, $language)
    {
        parent::__construct($resource);
        $this->settings = $settings;
        $this->language = $language;
    }

    /**
     * Transform the resource into an array.
     *
     * @throws IPinfoException
     */
    public function toArray($request): array
    {
        $settings = $this->settings;
        if ($settings == null)
            $settings = Setting::whereCountryId(AppHelper::getCoutnryForMobile())?->first() ?? Setting::where(['country_id' => null])->first();

        $language = $this->language;
        if ($language == null)
            $language = AppHelper::getLanguageForMobile();

        if ($language == 'ar')
            $currency = $settings->currency_ar;
        else
            $currency = $settings->currency_en;

        return [
            'id' => $this->id,
            'country' => $this->getTranslateValue($language, json_decode($this->country_meta, true), 'name', '') ?? '',
            'customer_name' => $this->customer_name ?? '',
            'customer_phone' => $this->customer_phone ?? '',
            'address' => $this->location_title ?? '',
            'agent' => $this->agent_name ?? '',
            'association' => $this->getAssociation($language),
            'status' => $this->getStatus($language),
            'type' => $this->getType($language),
            'weight' => $this->weight,
            'value' => $this->value . '' . $currency,
            'platform' => $this->platform,
            'failed_message' => $this->failed_message ?? '',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'start_at' => $this->start_at,
            'start_task' => $this->start_task,
            'ends_at' => $this->ends_at,
        ];
    }

    public function getAssociation($language)
    {
        if (!$this->association) {
            return 'Green Closet Company';
        }

        return $this->association?->getTranslateValue($language, json_decode($this->country_meta, true), 'title', '');
    }

    public function getStatus($local)
    {
        if ($local == 'ar') {
            if ($this->status == '1')
                return 'منشأ';
            if ($this->status == '2')
                return 'منسد';
            if ($this->status == '3')
                return 'مقبول';
            if ($this->status == '4')
                return 'مرفوض';
            if ($this->status == '5')
                return 'ملغي';
            if ($this->status == '6')
                return 'جاري توصليه';
            if ($this->status == '7')
                return 'فشل';
            if ($this->status == '8')
                return 'ناجح';
        } else {
            if ($this->status == '1')
                return 'CREATED';
            if ($this->status == '2')
                return 'ASSIGNED';
            if ($this->status == '3')
                return 'ACCEPTED';
            if ($this->status == '4')
                return 'DECLINE';
            if ($this->status == '5')
                return 'CANCEL';
            if ($this->status == '6')
                return 'DELIVERING';
            if ($this->status == '7')
                return 'FAILED';
            if ($this->status == '8')
                return 'SUCCESSFUL';
        }
    }

    public function getType($local)
    {
        if ($local == 'ar') {
            if ($this->type == '1')
                return 'تبرع';
            if ($this->type == '2')
                return 'اعادة تدوير';
        } else {
            if ($this->type == '1')
                return 'DONATION';
            if ($this->type == '2')
                return 'RECYCLING';
        }
    }
}
