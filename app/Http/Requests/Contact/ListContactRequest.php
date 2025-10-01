<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ListContactRequest extends FormRequest
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
            'name'    => 'nullable|string|max:150',
            'cpf'     => 'nullable|string|min:3|max:11|regex:/^\d+$/',
            'page'    => 'nullable|string',
            'records' => 'nullable|string'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.string' => 'O campo nome deve ser um texto válido.',
            'name.max'    => 'O campo nome não pode ter mais que :max caracteres.',
            'cpf.max'     => 'O CPF não pode conter mais de :max dígitos.',
            'cpf.min'     => 'Para consultar por CPF, digite pelo menos :min ou mais dígitos.',
            'cpf.regex'   => 'O CPF informado não é válido.',
        ];
    }
}
