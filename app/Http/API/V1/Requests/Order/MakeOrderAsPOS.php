<?php

namespace App\Http\API\V1\Requests\Order;

use App\Enums\OrderType;
use App\Models\Association;
use App\Models\Country;
use App\Models\Province;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MakeOrderAsPOS extends FormRequest
{
    public function rules(): array
    {

        $typeRules = ['required', 'numeric', Rule::in(OrderType::getValues())];

        $associationIdRules = [Rule::exists(Association::class, 'id')];

        $request = request()->all();
        if (isset($request)) {
            if (isset($request['association_id'])) {
                $typeRules[] = 'in:' . OrderType::DONATION;
                $associationIdRules[] = 'required';
            }
            if (isset($request['type'])) {
                if ($request['type'] == OrderType::DONATION) {
                    $associationIdRules[] = 'required';
                }
            }
        }

        return [
            'api_key' => ['required', 'max:255'],
            'name' => ['required', 'max:255'],
            'phone' => ['required', 'max:255'],
            'title' => ['required', 'max:255'],
            'platform' => ['required', 'max:255'],
            'agent_id' => ['required', 'numeric'],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'weight' => ['required', 'numeric'],
            'type' => $typeRules,
            'association_id' => $associationIdRules,
        ];
    }
}
