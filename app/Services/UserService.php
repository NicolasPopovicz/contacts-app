<?php

namespace App\Services;

use App\DTO\User\DeleteAccountDTO;
use App\DTO\User\ForgotPasswordDTO;
use App\DTO\User\LoginUserDTO;
use App\DTO\User\RegisterUserDTO;
use App\DTO\User\ResetPasswordDTO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Throwable;
use Exception;

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
        try {
            $user = User::create([
                'name'     => $dto->name,
                'email'    => $dto->email,
                'password' => bcrypt($dto->password),
            ]);
        } catch (Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return [
            'user'  => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ];
    }

    /**
     * @param  LoginUserDTO $dto
     * @return array|false
     */
    public function authenticateUser(LoginUserDTO $dto): array|false
    {
        $credentials = [
            'email'    => $dto->email,
            'password' => $dto->password
        ];

        if (!Auth::attempt($credentials)) {
            return false;
        }

        try {
            $user  = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
        } catch (Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return [
            'user'  => $user,
            'token' => $token
        ];
    }

    /**
     * @param  ForgotPasswordDTO $dto
     * @return boolean
     */
    public function sendEmailRecoverLogin(ForgotPasswordDTO $dto): bool
    {
        $status = Password::sendResetLink($dto->email);

        return $status === Password::RESET_LINK_SENT;
    }

    /**
     * @param  ResetPasswordDTO $dto
     * @return boolean
     */
    public function recreatePassword(ResetPasswordDTO $dto): bool
    {
        try {
            $status = Password::reset(
                [$dto->email, $dto->password, $dto->password_confirmation, $dto->token],
                function ($user, $password) {
                    $user->forceFill(['password' => Hash::make($password)])->save();

                    $user->tokens()->delete();
                }
            );
        } catch (Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return $status === Password::PASSWORD_RESET;
    }

    /**
     * @param  DeleteAccountDTO $dto
     * @return boolean
     */
    public function deleteUser(DeleteAccountDTO $dto): bool
    {
        $user = $dto->user;

        if (!Hash::check($dto->password, $user->password)) {
            return false;
        }

        try {
            $user->tokens()->delete();
            $user->delete();
        } catch (Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return true;
    }
}