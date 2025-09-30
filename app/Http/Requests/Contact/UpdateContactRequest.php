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
            'name'      => 'sometimes|required|string|min:3|max:150',
            'cpf'       => 'sometimes|required|string|size:11|regex:/^\d+$/|cpf|unique:contacts,cpf,' . $this->route('id'),
            'phone'     => 'sometimes|required|string|max:11',
            'address'   => 'nullable|string|max:200',
            'cep'       => 'sometimes|required|string|max:8',
            'state'     => 'sometimes|required|string|size:2',
            'latitude'  => 'sometimes|required|string|max:12',
            'longitude' => 'sometimes|required|string|max:12'
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.string'   => 'O campo name deve ser um texto válido.',
            'name.min'      => 'O campo name deve conter entre :min e :max caracteres.',
            'name.max'      => 'O campo name não pode ter mais que :max caracteres.',
            'cpf.size'      => 'O CPF deve conter :size dígitos.',
            'cpf.regex'     => 'O CPF informado não é válido.',
            'phone.max'     => 'O campo phone deve ser menor ou igual a :max dígitos.',
            'address.max'   => 'O campo address não pode ter mais que :max caracteres.',
            'cep.max'       => 'O campo cep não pode ter mais que :max dígitos.',
            'state.max'     => 'O campo state deve conter :size caracteres.',
            'latitude.max'  => 'O campo latitude não pode ter mais que :max caracteres.',
            'longitude.max' => 'O campo longitude não pode ter mais que :max caracteres.',
        ];
    }
}
