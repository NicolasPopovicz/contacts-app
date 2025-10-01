<?php

namespace App\DTO\User;

use App\Http\Requests\User\DeleteAccountRequest;

class DeleteAccountDTO
{
    public function __construct(
        public readonly mixed $user,
        public readonly string $password
    ) {}

    public static function fromRequest(DeleteAccountRequest $request): self
    {
        return new self(
            user:     $request->user(),
            password: $request->validated('password')
        );
    }
}
