<?php

namespace App\Http\API\V1\Requests\Offer;

use App\Enums\MediaType;
use App\Enums\OfferType;
use App\Models\Country;
use App\Models\MediaModel;
use App\Models\Partner;
use App\Traits\Language\ValidationHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOfferRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        $rulesValue = ['numeric'];
        $type = OfferType::FIXED;
        $request = request()->all();

        if (isset($request)) {
            if (isset($request['type'])) {
                $type = $request['type'];
            } else {
                $offer = $this->route()->parameter('offer');
                if (!$offer)
                    $type = $offer->type ?? $type;
            }
        }

        if ($type == OfferType::FIXED) {
            $rulesValue[] = 'min:1';
        } elseif ($type == OfferType::PERCENT) {
            $rulesValue[] = 'min:1';
            $rulesValue[] = 'max:100';
        }

        return array_merge([
            'name' => ['max:255'],
            'value' => $rulesValue,
            'image' => [Rule::exists(MediaModel::class, 'id')->where('type', MediaType::IMAGE)],
            'meta' => [''],
            'type' => [Rule::in(OfferType::getValues())],
            'country_id' => [Rule::exists(Country::class, 'id')],
            'partner_id' => [Rule::exists(Partner::class, 'id')],
        ], $this->getValidateItem(['name'], 'translate', ['max:255']));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
