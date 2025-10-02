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
            'name'       => 'required|string|min:3|max:150',
            'cpf'        => 'required|string|size:11|regex:/^\d+$/',
            'phone'      => 'required|string|max:11',
            'address'    => 'nullable|string|max:200',
            'complement' => 'nullable|string|max:75',
            'cep'        => 'required|string|max:8|regex:/^\d+$/',
            'number'     => 'required|string|max:10|regex:/^\d+$/',
            'city'       => 'required|string|max:75',
            'state'      => 'required|string|size:2',
            'latitude'   => 'required|string|max:12',
            'longitude'  => 'required|string|max:12'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.string'        => 'O campo Nome deve ser um texto válido.',
            'name.min'           => 'O campo Nome deve conter entre :min e :max caracteres.',
            'name.max'           => 'O campo Nome não pode ter mais que :max caracteres.',
            'name.required'      => 'O campo Nome é obrigatório.',
            'cpf.size'           => 'O campo CPF deve conter :size dígitos.',
            'cpf.regex'          => 'O campo CPF informado não é válido.',
            'cpf.required'       => 'O campo CPF é obrigatório.',
            'phone.max'          => 'O campo Telefone deve ser menor ou igual a :max dígitos.',
            'phone.required'     => 'O campo Telefone é obrigatório.',
            'address.max'        => 'O campo Endereço não pode ter mais que :max caracteres.',
            'complement.max'     => 'O campo Complemento não pode ter mais que :max caracteres.',
            'cep.max'            => 'O campo CEP não pode ter mais que :max dígitos.',
            'cep.regex'          => 'O campo CEP informado não é válido.',
            'cep.required'       => 'O campo CEP é obrigatório.',
            'number.max'         => 'O campo Número não pode ter mais que :max dígitos.',
            'number.regex'       => 'O campo Número informado não é válido.',
            'number.required'    => 'O campo Número é obrigatório.',
            'city.max'           => 'O campo Cidade não pode ter mais que :max dígitos.',
            'city.required'      => 'O campo Cidade é obrigatório.',
            'state.max'          => 'O campo Estado (UF) deve conter :size caracteres.',
            'state.required'     => 'O campo Estado (UF) é obrigatório.',
            'latitude.max'       => 'O campo Latitude não pode ter mais que :max caracteres.',
            'latitude.required'  => 'O campo Latitude é obrigatório.',
            'longitude.max'      => 'O campo Longitude não pode ter mais que :max caracteres.',
            'longitude.required' => 'O campo Longitude é obrigatório.',
        ];
    }
}
