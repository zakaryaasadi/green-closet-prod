<?php

namespace App\Http\API\V1\Requests\Order;

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Models\Association;
use App\Models\Country;
use App\Models\Item;
use App\Models\Province;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function rules(): array
    {

        $typeRules = ['numeric', Rule::in(OrderType::getValues())];

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
            'country_id' => [Rule::exists(Country::class, 'id')],
            'name' => ['max:255'],
            'province_id' => [Rule::exists(Province::class, 'id')],
            'phone' => [Rule::unique(User::class, 'phone')],
            'association_id' => $associationIdRules,
            'type' => $typeRules,
            'platform' => ['max:255'],
            'agent_id' => [Rule::exists(User::class, 'id')],
            'status' => ['numeric', Rule::in(OrderStatus::getValues())],
            'weight' => ['numeric'],
            'start_at' => ['date_format:Y-m-d H:i:s'],
            'ends_at' => ['date_format:Y-m-d H:i:s'],
            'start_task' => [],
            'location.lat' => ['numeric', 'between:-90,90'],
            'location.lng' => ['numeric', 'between:-180,180'],
            'location.title' => ['max:255'],
            'items' => [''],
            'items.*.id' => [Rule::exists(Item::class, 'id')],
            'items.*.weight' => ['numeric'],
            'image' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
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
