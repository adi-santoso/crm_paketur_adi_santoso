<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'company_id' => [
                'required',
                'integer',
                Rule::exists('companies', 'id')
                    ->withoutTrashed(),
            ],
            'name' => 'required|string|max:255|unique:employees,name',
            'phone' => 'required|string|unique:employees,phone',
            'address' => 'nullable|string'
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
