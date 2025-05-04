<?php

namespace App\Http\API\V1\Requests\Expense;

use App\Enums\ExpenseStatus;
use App\Models\Association;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExpenseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'containers_count' => ['numeric'],
            'orders_count' => ['numeric'],
            'orders_weight' => ['numeric'],
            'containers_weight' => ['numeric'],
            'weight' => ['numeric'],
            'value' => ['numeric'],
            'date' => ['date_format:Y-m-d H:i:s'],
            'status' => [Rule::in(ExpenseStatus::getValues())],
            'association_id' => [Rule::exists(Association::class, 'id')],
        ];
    }

    public function bodyParameters(): array
    {
        return [];
    }
}
