<?php

namespace App\DTO\Contact;

use App\Http\Requests\Contact\UpdateContactRequest;

class UpdateContactDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $cpf,
        public readonly ?string $phone,
        public readonly ?string $address,
        public readonly ?string $cep,
        public readonly ?string $state,
        public readonly ?string $latitude,
        public readonly ?string $longitude
    ) {}

    public static function fromRequest(UpdateContactRequest $request): self
    {
        $data = $request->validated();

        return new self(
            name:      $data['name'] ?? null,
            cpf:       $data['cpf'] ?? null,
            phone:     $data['phone'] ?? null,
            address:   $data['address'] ?? null,
            cep:       $data['cep'] ?? null,
            state:     $data['state'] ?? null,
            latitude:  $data['latitude'] ?? null,
            longitude: $data['longitude'] ?? null
        );
    }
}
