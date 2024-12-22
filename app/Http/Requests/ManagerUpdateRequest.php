<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:users,name,'. $this->route('id'),
            'email' => 'required|string|email|unique:users,email,'.$this->route('id'),
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
