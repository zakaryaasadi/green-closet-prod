<?php

namespace App\Http\API\V1\Requests\Point;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePointRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => [Rule::exists(User::class, 'id'),'required'],
            'order_id' => [Rule::exists(Order::class, 'id')->where('status', OrderStatus::SUCCESSFUL),'required'],
            'ends_at' => ['date_format:Y-m-d H:i:s', 'after_or_equal:' . date('Y-m-d H:i:s'),'required'],
            'count' => ['numeric','required'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
