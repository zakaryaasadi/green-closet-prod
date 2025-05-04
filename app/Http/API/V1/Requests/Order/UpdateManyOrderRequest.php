<?php

namespace App\Http\API\V1\Requests\Order;

use App\Enums\OrderStatus;
use App\Enums\UserType;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateManyOrderRequest extends FormRequest
{
    public function rules(): array
    {
        $startTaskRules = ['after_or_equal:' . Carbon::now()];
        $agentIdRules = [Rule::exists(User::class, 'id')->where('type', UserType::AGENT)];
        $statusRules = ['numeric', Rule::in(OrderStatus::getValues())];

        $request = request()->all();
        if (isset($request)) {
//            if (isset($request['status'])) {
//                if ($request['status'] == OrderStatus::ASSIGNED) {
//                    $agentIdRules[] = 'required';
//                    $startTaskRules[] = ['required'];
//                }
//            }
            if (isset($request['agent_id'])) {
                $statusRules[] = 'in:' . OrderStatus::ASSIGNED;
                $statusRules[] = 'required';
            }
        }

        return [
            'start_task' => $startTaskRules,
            'agent_id' => $agentIdRules,
            'status' => $statusRules,
            'orders_ids' => ['required'],
            'orders_ids.*' => [Rule::exists(Order::class, 'id')],

        ];
    }
}
