<?php

namespace App\Http\API\V1\Requests\Target;

use App\Enums\MonthsEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTargetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'orders_count' => ['numeric'],
            'weight_target' => ['numeric'],
            'month' => [Rule::in(MonthsEnum::getValues())],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
