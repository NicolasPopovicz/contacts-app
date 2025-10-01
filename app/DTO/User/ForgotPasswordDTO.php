<?php

namespace App\DTO\User;

use App\Http\Requests\User\ForgotPasswordRequest;

class ForgotPasswordDTO
{
    public function __construct(public readonly string $email) {}

    public static function fromRequest(ForgotPasswordRequest $request): self
    {
        return new self(email: $request->validated('email'));
    }
}
