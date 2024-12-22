<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:companies,name,' .$this->route('id'),
            'email' => 'required|string|email|unique:companies,email,'.$this->route('id'),
            'phone' => 'nullable|string|unique:companies,phone,' .$this->route('id')
        ];
    }

    public function authorize(): bool
    {
        return auth()->check();
    }
}
