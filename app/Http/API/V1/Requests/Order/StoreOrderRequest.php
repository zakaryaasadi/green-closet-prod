<?php

namespace App\Http\API\V1\Requests\Order;

use App\Enums\OrderType;
use App\Models\Address;
use App\Models\Association;
use App\Models\Country;
use App\Models\Message;
use App\Models\Province;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function rules(): array
    {

        $typeRules = ['required', 'numeric', Rule::in(OrderType::getValues())];

        $associationIdRules = [Rule::exists(Association::class, 'id')];

        $required = 'required';

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

            if (isset($request['address_id']))
                $required = 'nullable';

        }

        return [
            'name' => ['required', 'max:255'],
            'platform' => ['required', 'max:255'],
            'message_id' => [Rule::exists(Message::class, 'id')],
            'address_id' => [Rule::exists(Address::class, 'id')],
            'province_id' => [$required, Rule::exists(Province::class, 'id')],
            'country_id' => ['required', Rule::exists(Country::class, 'id')],
            'phone' => ['required', 'min:6'],
            'location.lat' => [$required, 'numeric', 'between:-90,90'],
            'location.lng' => [$required, 'numeric', 'between:-180,180'],
            'location.title' => [$required, 'max:255'],
            'type' => $typeRules,
            'association_id' => $associationIdRules,
            'apartment_number' => ['max:255'],
            'floor_number' => ['max:255'],
            'building' => ['max:255'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
