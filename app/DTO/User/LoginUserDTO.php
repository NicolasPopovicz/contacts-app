<?php

namespace App\DTO\User;

use App\Http\Requests\User\LoginRequest;

class LoginUserDTO
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {}

    public static function fromRequest(LoginRequest $request): self
    {
        return new self(
            email:    $request->validated('email'),
            password: $request->validated('password')
        );
    }
}
