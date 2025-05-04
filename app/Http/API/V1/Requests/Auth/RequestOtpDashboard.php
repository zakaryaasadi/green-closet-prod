<?php

namespace App\Http\API\V1\Requests\Auth;

use App\Enums\OrderType;
use App\Models\Association;
use App\Models\Item;
use App\Models\Province;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RequestOtpDashboard extends FormRequest
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
            'name' => ['required', 'max:255'],
            'phone' => ['required', 'max:255'],
            'title' => ['required', 'max:255'],
            'items' => ['required'],
            'items.*' => [Rule::exists(Item::class, 'id'), 'required'],
            'apartment_number' => ['max:255'],
            'floor_number' => ['max:255'],
            'building' => ['max:255'],
            'province_id' => ['required', Rule::exists(Province::class, 'id')],
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
            'type' => $typeRules,
            'association_id' => $associationIdRules,
        ];
    }
}
