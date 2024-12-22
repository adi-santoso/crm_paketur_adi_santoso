<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:employees,name,'. $this->route('id'),
            'phone' => 'required|string|unique:employees,phone,'. $this->route('id'),
            'address' => 'nullable|string'
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
