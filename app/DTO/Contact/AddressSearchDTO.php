<?php

namespace App\DTO\Contact;

use App\Http\Requests\Contact\AddressRequest;

class AddressSearchDTO
{
    public function __construct(
        public readonly ?string $cep,
        public readonly ?string $state,
        public readonly ?string $city,
        public readonly ?string $address
    ) {}

    public static function fromRequest(AddressRequest $request): self
    {
        return new self(
            cep:     $request->validated('cep'),
            state:   $request->validated('state'),
            city:    $request->validated('city'),
            address: $request->validated('address')
        );
    }
}
