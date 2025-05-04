<?php

namespace App\Http\API\V1\Requests\Order;

use App\Enums\OrderType;
use App\Models\Address;
use App\Models\Association;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerOrderRequest extends FormRequest
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
            'address_id' => ['required', Rule::exists(Address::class, 'id')->where('user_id', Auth::id())],
            'type' => $typeRules,
            'association_id' => $associationIdRules,
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
