<?php

namespace App\Services;

use App\DTO\User\RegisterUserDTO;
use App\Models\User;

class UserService
{
    public function __construct(private User $user)
    {
        $this->user = $user;
    }

    /**
     * @param  RegisterUserDTO $dto
     * @return array
     */
    public function createUser(RegisterUserDTO $dto): array
    {
        $user = User::create([
            'name'     => $dto->name,
            'email'    => $dto->email,
            'password' => bcrypt($dto->password),
        ]);

        return [
            'user'  => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

    public function authenticateUser()
    {

    }

    public function revokeToken()
    {

    }

    public function sendEmailRecoverLogin()
    {

    }

    public function recreatePassword()
    {

    }

    public function deleteUser()
    {

    }
}