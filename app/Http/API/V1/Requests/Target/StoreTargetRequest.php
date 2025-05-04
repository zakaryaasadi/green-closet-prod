<?php

namespace App\Http\API\V1\Requests\Target;

use App\Enums\MonthsEnum;
use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTargetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'orders_count' => ['required', 'numeric'],
            'weight_target' => ['required', 'numeric'],
            'month' => ['required', Rule::in(MonthsEnum::getValues())],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
