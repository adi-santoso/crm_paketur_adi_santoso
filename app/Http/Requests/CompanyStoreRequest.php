<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:companies,name',
            'email' => 'required|email|unique:companies,email',
            'phone' => 'nullable|string|unique:companies,phone'
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
