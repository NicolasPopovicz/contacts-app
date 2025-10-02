<?php

namespace App\Http\Controllers;

use App\DTO\User\DeleteAccountDTO;
use App\DTO\User\ForgotPasswordDTO;
use App\DTO\User\LoginUserDTO;
use App\DTO\User\RegisterUserDTO;
use App\DTO\User\ResetPasswordDTO;
use App\Http\Requests\User\DeleteAccountRequest;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param  RegisterUserRequest $req
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $req): JsonResponse
    {
        $dto = RegisterUserDTO::fromRequest($req);

        $data = $this->userService->createUser($dto);

        return $this->handleReturn(true, 'Usuário registrado com sucesso.', $data, 201);
    }

    /**
     * @param  LoginRequest $req
     * @return JsonResponse
     */
    public function login(LoginRequest $req): JsonResponse
    {
        $dto = LoginUserDTO::fromRequest($req);

        $data = $this->userService->authenticateUser($dto);

        $return = !$data
            ? [false, "Credenciais inválidas.", [], 400]
            : [true, "Login realizado com sucesso!", $data, 200];

        return $this->handleReturn(...$return);
    }

    /**
     * @param  Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return $this->handleReturn(true, "Logout realizado com sucesso!");
    }

    /**
     * @param  ForgotPasswordRequest $req
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $req): JsonResponse
    {
        $dto = ForgotPasswordDTO::fromRequest($req);

        $data = $this->userService->sendEmailRecoverLogin($dto);

        $return = !$data
            ? [false, "Não foi possível enviar o link.", [], 500]
            : [true, "Link de recuperação enviado para o e-mail '{$dto->email}'.", [], 200];

        return $this->handleReturn(...$return);
    }

    /**
     * @param  ResetPasswordRequest $req
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $req): JsonResponse
    {
        $dto = ResetPasswordDTO::fromRequest($req);

        $data = $this->userService->recreatePassword($dto);

        $return = !$data
            ? [false, "Falha ao redefinir senha.", [], 500]
            : [true, "Senha redefinida com sucesso!", [], 200];

        return $this->handleReturn(...$return);
    }

    /**
     * @param  DeleteAccountRequest $req
     * @return JsonResponse
     */
    public function deleteAccount(DeleteAccountRequest $req): JsonResponse
    {
        $dto = DeleteAccountDTO::fromRequest($req);

        $data = $this->userService->deleteUser($dto);

        $return = !$data
            ? [false, "Senha incorreta. Não foi possível excluir a conta.", [], 400]
            : [true, "Conta excluída com sucesso!", [], 200];

        return $this->handleReturn(...$return);
    }
}
