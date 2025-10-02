<?php

namespace App\DTO\Contact;

use App\Http\Requests\Contact\CreateContactRequest;

class CreateContactDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $cpf,
        public readonly string $phone,
        public readonly ?string $address,
        public readonly ?string $complement,
        public readonly string $cep,
        public readonly string $number,
        public readonly string $city,
        public readonly string $state,
        public readonly string $latitude,
        public readonly string $longitude
    ) {}

    public static function fromRequest(CreateContactRequest $request): self
    {
        return new self(
            name:       $request->validated('name'),
            cpf:        $request->validated('cpf'),
            phone:      $request->validated('phone'),
            address:    $request->validated('address'),
            complement: $request->validated('complement'),
            cep:        $request->validated('cep'),
            number:     $request->validated('number'),
            city:       $request->validated('city'),
            state:      $request->validated('state'),
            latitude:   $request->validated('latitude'),
            longitude:  $request->validated('longitude')
        );
    }
}
