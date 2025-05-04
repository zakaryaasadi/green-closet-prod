<?php

namespace App\Http\API\V1\Requests\ContainerDetails;

use App\Enums\ContainerStatus;
use App\Enums\UserType;
use App\Models\Container;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdminContainerDetailsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'container_id' => ['required', Rule::exists(Container::class, 'id')
                ->where('status', ContainerStatus::ON_THE_FIELD), ],
            'agent_id' => ['required', Rule::exists(User::class, 'id')
                ->where('type', UserType::AGENT),],
            'weight' => ['required', 'numeric'],
            'date' => ['required', 'date_format:Y-m-d H:i']
        ];
    }
}
