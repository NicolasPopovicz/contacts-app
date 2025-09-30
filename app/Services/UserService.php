<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function __construct(private User $user)
    {
        $this->user = $user;
    }
}