<?php

namespace App\Http\API\V1\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class NearOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'lat' => ['numeric', 'between:-90,90'],
            'lng' => ['numeric', 'between:-180,180'],
        ];
    }
}
