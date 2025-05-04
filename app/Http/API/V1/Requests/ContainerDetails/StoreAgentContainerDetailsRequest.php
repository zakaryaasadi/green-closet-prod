<?php

namespace App\Http\API\V1\Requests\ContainerDetails;

use App\Enums\ContainerStatus;
use App\Models\Container;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAgentContainerDetailsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'container_id' => ['required', Rule::exists(Container::class, 'id')
                ->where('status', ContainerStatus::ON_THE_FIELD), ],
            'weight' => ['required', 'numeric'],
        ];
    }
}
