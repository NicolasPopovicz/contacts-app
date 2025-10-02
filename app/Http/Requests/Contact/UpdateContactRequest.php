<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
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
            'name'       => 'sometimes|required|string|min:3|max:150',
            'cpf'        => 'sometimes|required|string|size:11|regex:/^\d+$/',
            'phone'      => 'sometimes|required|string|max:11',
            'address'    => 'nullable|string|max:200',
            'complement' => 'nullable|string|max:75',
            'cep'        => 'sometimes|required|string|max:8|regex:/^\d+$/',
            'number'     => 'sometimes|required|string|max:10|regex:/^\d+$/',
            'city'       => 'sometimes|required|string|max:75',
            'state'      => 'sometimes|required|string|size:2',
            'latitude'   => 'sometimes|required|string|max:12',
            'longitude'  => 'sometimes|required|string|max:12'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.string'    => 'O campo Nome deve ser um texto válido.',
            'name.min'       => 'O campo Nome deve conter entre :min e :max caracteres.',
            'name.max'       => 'O campo Nome não pode ter mais que :max caracteres.',
            'cpf.size'       => 'O campo CPF deve conter :size dígitos.',
            'cpf.regex'      => 'O campo CPF informado não é válido.',
            'phone.max'      => 'O campo Telefone deve ser menor ou igual a :max dígitos.',
            'address.max'    => 'O campo Endereço não pode ter mais que :max caracteres.',
            'complement.max' => 'O campo Complemento não pode ter mais que :max caracteres.',
            'cep.max'        => 'O campo CEP não pode ter mais que :max dígitos.',
            'cep.regex'      => 'O campo CEP informado não é válido.',
            'number.max'     => 'O campo Número não pode ter mais que :max dígitos.',
            'number.regex'   => 'O campo Número informado não é válido.',
            'city.max'       => 'O campo Cidade não pode ter mais que :max dígitos.',
            'state.max'      => 'O campo Estado (UF) deve conter :size caracteres.',
            'latitude.max'   => 'O campo Latitude não pode ter mais que :max caracteres.',
            'longitude.max'  => 'O campo Longitude não pode ter mais que :max caracteres.',
        ];
    }
}
