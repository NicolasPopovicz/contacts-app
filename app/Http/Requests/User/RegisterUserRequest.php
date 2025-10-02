<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'name'     => 'required|string|max:150',
            'email'    => 'required|string|email|min:3|max:200',
            'password' => 'required|string|min:5|max:50'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'     => 'O campo Nome é obrigatório.',
            'name.string'       => 'O campo Nome deve ser um texto válido.',
            'name.max'          => 'O campo Nome não pode ter mais que :max caracteres.',
            'email.required'    => 'O campo E-mail é obrigatório.',
            'email.string'      => 'O campo E-mail deve ser um texto válido.',
            'email.email'       => 'O campo E-mail deve ser válido.',
            'email.min'         => 'O campo E-mail deve ter mais do que :min caracteres.',
            'email.max'         => 'O campo E-mail não pode conter mais de :max caracteres.',
            'password.required' => 'O campo Senha é obrigatório.',
            'password.string'   => 'O campo Senha deve ser um texto válido.',
            'password.min'      => 'O campo Senha deve ter mais do que :min caracteres.',
            'password.max'      => 'O campo Senha não pode conter mais de :max caracteres.',
        ];
    }
}
