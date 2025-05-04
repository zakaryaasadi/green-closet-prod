<?php

namespace App\Http\API\V1\Requests\ContainerDetails;

use App\Enums\ContainerStatus;
use App\Enums\UserType;
use App\Models\Container;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContainerDetailsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'container_id' => [Rule::exists(Container::class, 'id')
                ->where('status', ContainerStatus::ON_THE_FIELD),],
            'agent_id' => [Rule::exists(User::class, 'id')
                ->where('type', UserType::AGENT),],
            'weight' => ['numeric'],
            'value' => ['numeric'],
        ];
    }
}
