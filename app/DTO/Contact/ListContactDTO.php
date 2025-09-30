<?php

namespace App\DTO\Contact;

use App\Http\Requests\Contact\ListContactRequest;

class ListContactDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $cpf,
    ) {}

    public static function fromRequest(ListContactRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            cpf:  $request->validated('cpf'),
        );
    }
}
