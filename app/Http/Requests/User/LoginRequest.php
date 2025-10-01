<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'    => 'required|string|email|min:3|max:200',
            'password' => 'required|string|min:3|max:50'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required'    => 'O campo email é obrigatório.',
            'email.string'      => 'O campo email deve ser um texto válido.',
            'email.email'       => 'O campo email deve ser válido.',
            'email.min'         => 'O campo email deve ter entre :min e :max caracteres.',
            'email.max'         => 'O campo email não pode conter mais de :max caracteres.',
            'password.required' => 'O campo password é obrigatório.',
            'password.string'   => 'O campo password deve ser um texto válido.',
            'password.min'      => 'O campo password deve ter entre :min e :max caracteres.',
            'password.max'      => 'O campo password não pode conter mais de :max caracteres.',
        ];
    }
}
