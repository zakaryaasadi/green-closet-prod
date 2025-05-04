<?php

namespace App\Http\API\V1\Requests\Order\Status;

use App\Models\Item;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MakeOrderSuccessfulRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'items' => ['required'],
            'items.*.id' => [Rule::exists(Item::class, 'id'), 'required'],
            'items.*.weight' => ['required', 'numeric'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
            'agent_payment' => ['numeric'],
        ];
    }
}
