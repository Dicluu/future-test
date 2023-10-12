<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            // Изменяем phone и email только в том случае, если они уникальны. Игнорируем существование данных полей у контакта, которого собираемся изменить.
            'phone' => ['nullable', Rule::unique('contacts')->ignore($this->route()->parameters['notebook'])],
            'email' => ['required', Rule::unique('contacts')->ignore($this->route()->parameters['notebook'])],
            'date_of_birth' => 'nullable|date',
            'img_url' => 'nullable|string'
        ];
    }
}
