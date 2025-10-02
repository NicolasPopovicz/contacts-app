<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'cep'     => 'sometimes|required|size:8|regex:/^\d+$/',
            'state'   => 'sometimes|required|string|size:2',
            'city'    => 'sometimes|required|string|min:3',
            'address' => 'sometimes|required|string|min:3',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'cep.size'      => "O campo 'cep' deve conter :size dígitos.",
            'cep.regex'     => "O campo 'cep' informado não é válido.",
            'state.size'    => "O campo 'state' deve conter :size caracteres.",
            'city.min'      => "O campo 'city' deve conter no mínimo :size caracteres.",
            'address.min'   => "O campo 'address' deve conter no mínimo :size caracteres."
        ];
    }
}
