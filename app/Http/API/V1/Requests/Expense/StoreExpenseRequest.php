<?php

namespace App\Http\API\V1\Requests\Expense;


use App\Enums\ExpenseStatus;
use App\Models\Association;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpenseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'containers_count' => ['required', 'numeric'],
            'orders_count' => ['required', 'numeric'],
            'orders_weight' => ['required', 'numeric'],
            'containers_weight' => ['required', 'numeric'],
            'weight' => ['required', 'numeric'],
            'value' => ['required', 'numeric'],
            'date' => ['date_format:Y-m-d H:i:s', 'required'],
            'status' => ['required', Rule::in(ExpenseStatus::getValues())],
            'association_id' => [Rule::exists(Association::class, 'id'), 'required'],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
