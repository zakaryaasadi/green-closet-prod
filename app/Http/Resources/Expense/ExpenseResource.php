<?php

namespace App\Http\Resources\Expense;

use App\Helpers\AppHelper;
use App\Http\Resources\Association\SimpleAssociationResource;
use App\Models\Expense;
use App\Models\Setting;
use App\Traits\Language\TranslateHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use ipinfo\ipinfo\IPinfoException;

/**
 * @mixin Expense
 **/
class ExpenseResource extends JsonResource
{
    use TranslateHelper;

    /**
     * Transform the resource into an array.
     *
     * @throws IPinfoException
     */
    public function toArray($request): array
    {
        $locale = AppHelper::getLanguageForMobile();
        $country = AppHelper::getCoutnryForMobile();
        $settings = Setting::whereCountryId($country->id)?->first();
        if ($this->association)
            $association_name = $this->getTranslateValue($locale, $this->association?->meta, 'title', $this->association->title);
        else
            $association_name = '';
        if ($locale == 'ar') {
            $message = "طلبت  $association_name سحب مستحقات ";
            $currency = $settings?->currency_ar ?? '';
        } else {
            $message = "$association_name request to drag Financial Dues";
            $currency = $settings?->currency_en ?? '';

        }

        return [
            'id' => $this->id,
            'containers_count' => $this->containers_count,
            'orders_count' => $this->orders_count,
            'orders_weight' => $this->orders_weight,
            'containers_weight' => $this->containers_weight,
            'weight' => $this->weight,
            'value' => $this->value,
            'date' => $this->date,
            'status' => $this->status,
            'association' => $this->getSimpleAssociationResource(),
            'admin_message' => $message,
            'currency' => $currency,
        ];
    }

    public function getSimpleAssociationResource(): ?SimpleAssociationResource
    {
        if (!$this->association)
            return null;

        return new SimpleAssociationResource($this->association);
    }
}
