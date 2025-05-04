<?php

namespace App\Http\API\V1\Requests\Order;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteManyOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'orders_ids' => ['required'],
            'orders_ids.*' => [Rule::exists(Order::class, 'id')],
        ];
    }
}
