<?php

namespace App\DTO\Contact;

use App\Http\Requests\Contact\ListContactRequest;

class ListContactDTO
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $cpf,
        public readonly ?int $page,
        public readonly ?int $records
    ) {}

    public static function fromRequest(ListContactRequest $request): self
    {
        return new self(
            name:    $request->validated('name'),
            cpf:     $request->validated('cpf'),
            page:    $request->validated('page') ?? 1,
            records: $request->validated('records') ?? 10,
        );
    }
}
