<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class DeleteAccountRequest extends FormRequest
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
            'password' => 'required|string|min:3|max:50'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'password.required' => 'O campo password é obrigatório.',
            'password.string'   => 'O campo password deve ser um texto válido.',
            'password.min'      => 'O campo password deve ter entre :min e :max caracteres.',
            'password.max'      => 'O campo password não pode conter mais de :max caracteres.',
        ];
    }
}
