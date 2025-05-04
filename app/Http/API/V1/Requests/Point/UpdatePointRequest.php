<?php

namespace App\Http\API\V1\Requests\Point;

use App\Enums\PointStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePointRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => [Rule::exists(User::class, 'id')],
            'order_id' => [Rule::exists(Order::class, 'id')],
            'status' => ['numeric', Rule::in(PointStatus::getValues())],
            'ends_at' => ['date_format:Y-m-d H:i:s', 'after_or_equal:' . date('Y-m-d H:i:s')],
            'count' => ['numeric'],
            'used' => ['boolean'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
