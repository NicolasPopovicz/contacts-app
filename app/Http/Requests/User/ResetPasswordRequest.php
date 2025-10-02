<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'token'    => 'required',
            'email'    => 'required|string|email|max:200',
            'password' => 'required|string|max:50|confirmed',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'token.required'    => 'O Token é obrigatório.',
            'email.required'    => 'O campo E-mail é obrigatório.',
            'email.string'      => 'O campo E-mail deve ser um texto válido.',
            'email.email'       => 'O campo E-mail deve ser válido.',
            'email.max'         => 'O campo E-mail não pode conter mais de :max caracteres.',
            'password.required' => 'O campo Senha é obrigatório.',
            'password.string'   => 'O campo Senha deve ser um texto válido.',
            'password.max'      => 'O campo Senha não pode conter mais de :max caracteres.',
        ];
    }
}
