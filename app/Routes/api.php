<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
// Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Route::middleware('auth:sanctum')->group(function () {
//     // Usuário
//     Route::get('/me', [UserController::class, 'me']);
//     Route::delete('/me', [UserController::class, 'deleteAccount']);
//     Route::post('/logout', [AuthController::class, 'logout']);

    // Contatos
    Route::get('/contacts/list', [ContactController::class, 'index']);   // listagem com filtros
    Route::post('/contact/create', [ContactController::class, 'store']);  // criar
    Route::get('/contact/{id}', [ContactController::class, 'show']); // detalhes
    Route::put('/contact/{id}/update', [ContactController::class, 'update']); // atualizar
    Route::delete('/contact/{id}/delete', [ContactController::class, 'destroy']); // excluir
// });
