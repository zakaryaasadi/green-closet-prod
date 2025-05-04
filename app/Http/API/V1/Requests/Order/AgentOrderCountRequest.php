<?php

namespace App\Http\API\V1\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class AgentOrderCountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'start_task' => ['date_format:Y-m-d'],
        ];
    }
}
