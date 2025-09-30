<?php

namespace App\Http\Controllers;

// use App\Application\UseCases\User\RegisterUser;
// use App\Domain\User\Repositories\UserRepositoryInterface;
// use App\Interfaces\Http\Requests\RegisterRequest;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Routing\Controller;

class AuthController extends Controller
{
//     private RegisterUser $registerUser;
//     private UserRepositoryInterface $userRepository;

//     public function __construct(RegisterUser $registerUser, UserRepositoryInterface $userRepository)
//     {
//         $this->registerUser = $registerUser;
//         $this->userRepository = $userRepository;
//     }

//     /**
//      * Cadastro de usuário
//      */
//     public function register(RegisterRequest $request)
//     {
//         $user = $this->registerUser->execute(
//             $request->name,
//             $request->email,
//             $request->password
//         );

//         return response()->json([
//             'id'    => $user->getId(),
//             'name'  => $user->getName(),
//             'email' => (string) $user->getEmail(),
//         ], 201);
//     }

//     /**
//      * Login - retorna token Sanctum
//      */
//     public function login(Request $request)
//     {
//         $credentials = $request->validate([
//             'email'    => ['required', 'email'],
//             'password' => ['required'],
//         ]);

//         if (!Auth::attempt($credentials)) {
//             return response()->json(['message' => 'Credenciais inválidas'], 401);
//         }

//         $user = Auth::user();

//         $token = $user->createToken('auth_token')->plainTextToken;

//         return response()->json([
//             'access_token' => $token,
//             'token_type'   => 'Bearer',
//         ]);
//     }

//     /**
//      * Logout - revoga token atual
//      */
//     public function logout(Request $request)
//     {
//         $request->user()->currentAccessToken()->delete();

//         return response()->json(['message' => 'Logout realizado com sucesso']);
//     }

//     /**
//      * Retorna dados do usuário logado
//      */
//     public function me(Request $request)
//     {
//         return response()->json($request->user());
//     }
}
