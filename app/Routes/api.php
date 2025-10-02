<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/register',        [AuthController::class, 'register']);
Route::post('/login',           [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password',  [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {
    // Usuário
    Route::post('/logout',        [AuthController::class, 'logout']);
    Route::delete('/user/delete', [AuthController::class, 'deleteAccount']);

    // Contatos
    Route::get('/contacts/list',          [ContactController::class, 'index']);
    Route::post('/contact/create',        [ContactController::class, 'store']);
    Route::put('/contact/{id}/update',    [ContactController::class, 'update']);
    Route::delete('/contact/{id}/delete', [ContactController::class, 'destroy']);

    // ViaCep
    Route::get('/address/search',  [ContactController::class, 'searchContactAddress']);
});
