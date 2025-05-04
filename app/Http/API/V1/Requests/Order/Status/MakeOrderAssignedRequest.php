<?php

namespace App\Http\API\V1\Requests\Order\Status;

use App\Enums\UserType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MakeOrderAssignedRequest extends FormRequest
{
    public function rules(): array
    {
        $agent = '';
        $request = request()->all();
        if (isset($request)) {
            if (isset($request['agent_id'])) {
                $agent = User::whereId($request['agent_id'])->first();
                $tasksPerDay = $agent->agentSettings?->tasks_per_day;
                $agentTasks = $agent->agentOrdersCount(Carbon::now('UTC'));
            }
        }

        return [
            'agent_id' => [
                'required',
                Rule::exists(User::class, 'id')->where('type', UserType::AGENT),
            ],
            'start_task' => ['required', 'date_format:Y-m-d H:i:s', 'after_or_equal:' . date('Y-m-d H:i:s')],
        ];
    }
}
