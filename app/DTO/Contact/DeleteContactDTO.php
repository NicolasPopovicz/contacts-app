<?php

namespace App\DTO\Contact;

use App\Http\Requests\Contact\DeleteContactRequest;

class DeleteContactDTO
{
    public function __construct(public readonly int $id) {}

    public static function fromRequest(DeleteContactRequest $request): self
    {
        return new self((int) $request->route('id'));
    }
}
