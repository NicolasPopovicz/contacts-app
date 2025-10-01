<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class CreateContactRequest extends FormRequest
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
            'name'      => 'required|string|min:3|max:150',
            'cpf'       => 'required|string|size:11|regex:/^\d+$/',
            'phone'     => 'required|string|max:11',
            'address'   => 'nullable|string|max:200',
            'cep'       => 'required|string|max:8',
            'state'     => 'required|string|size:2',
            'latitude'  => 'required|string|max:12',
            'longitude' => 'required|string|max:12'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.string'        => 'O campo name deve ser um texto válido.',
            'name.min'           => 'O campo name deve conter entre :min e :max caracteres.',
            'name.max'           => 'O campo name não pode ter mais que :max caracteres.',
            'name.required'      => 'O campo name é obrigatório.',
            'cpf.size'           => 'O CPF deve conter :size dígitos.',
            'cpf.regex'          => 'O CPF informado não é válido.',
            'cpf.required'       => 'O campo CPF é obrigatório.',
            'phone.max'          => 'O campo phone deve ser menor ou igual a :max dígitos.',
            'phone.required'     => 'O campo phone é obrigatório.',
            'address.max'        => 'O campo address não pode ter mais que :max caracteres.',
            'cep.max'            => 'O campo cep não pode ter mais que :max dígitos.',
            'cep.required'       => 'O campo cep é obrigatório.',
            'state.max'          => 'O campo state deve conter :size caracteres.',
            'state.required'     => 'O campo state é obrigatório.',
            'latitude.max'       => 'O campo latitude não pode ter mais que :max caracteres.',
            'latitude.required'  => 'O campo latitude é obrigatório.',
            'longitude.max'      => 'O campo longitude não pode ter mais que :max caracteres.',
            'longitude.required' => 'O campo longitude é obrigatório.',
        ];
    }
}
