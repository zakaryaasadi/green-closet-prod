<?php

namespace App\Http\API\V1\Requests\Order\Status;

use App\Models\Message;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MakeOrderCanceledRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message' => ['max:255'],
            'message_id' => [Rule::exists(Message::class, 'id')],
            'start_task' => [],
        ];
    }
}
