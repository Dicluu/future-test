<?php

namespace App\Http\Requests\Notebook;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'full_name' => 'required|max:80',
            'company_name' => 'nullable|string',
            'phone' => 'nullable|unique:notebooks,phone',
            'email' => 'required|unique:notebooks,email',
            'date_of_birth' => 'nullable|date',
            'img_url' => 'nullable|string'
        ];
    }
}
