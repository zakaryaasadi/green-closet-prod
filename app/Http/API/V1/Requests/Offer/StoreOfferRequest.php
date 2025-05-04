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

class StoreOfferRequest extends FormRequest
{
    use ValidationHelper;

    public function rules(): array
    {
        $rulesValue = ['required', 'numeric'];

        $request = request()->all();
        if (isset($request)) {
            if (isset($request['type'])) {
                if ($request['type'] == OfferType::FIXED) {
                    $rulesValue[] = 'min:1';
                } elseif ($request['type'] == OfferType::PERCENT) {
                    $rulesValue[] = 'min:1';
                    $rulesValue[] = 'max:100';
                }
            }
        }


        return array_merge([
            'value' => $rulesValue,
            'name' => ['max:255'],
            'image' => ['required', Rule::exists(MediaModel::class, 'id')->where('type', MediaType::IMAGE)],
            'meta' => ['required'],
            'type' => ['required', Rule::in(OfferType::getValues())],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'partner_id' => ['required', Rule::exists(Partner::class, 'id')],
        ], $this->getValidateItem(['name'], 'translate', ['required', 'max:255']));
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
