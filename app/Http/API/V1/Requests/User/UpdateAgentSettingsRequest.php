<?php

namespace App\Http\API\V1\Requests\User;

use App\Enums\DaysEnum;
use App\Enums\DischargeShift;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAgentSettingsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'agent_id' => ['required', Rule::exists(User::class, 'id')->where('type', UserType::AGENT)],
            'tasks_per_day' => ['required', 'numeric'],
            'budget' => ['required', 'numeric'],
            'holiday' => ['required', Rule::in(DaysEnum::getValues())],
            'start_work' => ['required', 'date_format:H:i'],
            'finish_work' => ['required', 'date_format:H:i'],
            'work_shift' => ['required', Rule::in(DischargeShift::getValues())],
        ];
    }
}
