<?php

namespace App\Http\API\V1\Requests\ContainerDetails;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetContainerDetailsRequest extends FormRequest
{
    public function rules(): array
    {
        $endDataValidate = ['date_format:Y-m-d H:i'];
        $request = request()->all();
        if (isset($request)) {
            if (isset($request['start_date']))
                $endDataValidate = array_merge($endDataValidate, ['after_or_equal:' . $request['start_date']]);
        }

        return [
            'agent_id' => [Rule::exists(User::class, 'id')
                ->where('type', UserType::AGENT),],
            'start_date' => ['date_format:Y-m-d H:i'],
            'end_date' => $endDataValidate,
        ];
    }
}
