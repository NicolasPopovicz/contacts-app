<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('registra um novo usuário', function () {
    $payload = [
        'name' => 'Teste',
        'email' => 'teste@example.com',
        'password' => 'secret123',
        'password_confirmation' => 'secret123',
    ];

    $response = $this->postJson('/api/register', $payload);

    $response->assertStatus(201)
             ->assertJsonStructure([
                 'success',
                 'data' => [
                     'user' => ['id', 'name', 'email'],
                     'token'
                 ]
             ]);

    $this->assertDatabaseHas('users', ['email' => 'teste@example.com']);
});

it('faz login com credenciais corretas', function () {
    $user = User::factory()->create([
        'password' => Hash::make('senha123')
    ]);

    $response = $this->postJson('/api/login', [
        'email' => $user->email,
        'password' => 'senha123'
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'success',
                 'data' => [
                     'user' => ['id', 'name', 'email'],
                     'token'
                 ]
             ]);
});