<?php

namespace App\Http\API\V1\Requests\Order;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderItemsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'items' => ['required'],
            'items.*.id' => ['required', Rule::exists(Item::class, 'id')],
            'items.*.weight' => ['numeric', 'required'],
        ];
    }
}
