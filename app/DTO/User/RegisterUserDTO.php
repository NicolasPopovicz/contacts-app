<?php

namespace App\DTO\User;

use App\Http\Requests\User\RegisterUserRequest;

class RegisterUserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password
    ) {}

    public static function fromRequest(RegisterUserRequest $request): self
    {
        return new self(
            name:     $request->validated('name'),
            email:    $request->validated('email'),
            password: $request->validated('password')
        );
    }
}
