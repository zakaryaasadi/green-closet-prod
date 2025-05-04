<?php

namespace App\Http\API\V1\Requests\Point;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerPointsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => [Rule::exists(User::class, 'id'),'required'],
            'order_id' => [Rule::exists(Order::class, 'id')->where('status', OrderStatus::COMPLETED),'required'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
