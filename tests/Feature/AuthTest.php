<?php

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

describe('Testing User\'s actions on the application', function () {
    it('should register a user successfully', function () {
        $payload = generateRandomUserObject();

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => ['id', 'name', 'email'],
                    'token'
                ]
            ]);

        $this->assertDatabaseHas('users', ['email' => $payload['email']]);
    });

    it('should login in the application successfully', function () {
        $user = getRandomUser();

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => ['id', 'name', 'email'],
                    'token'
                ]
            ]);
    });

    it('should do the process of recovering the password (send link to an e-mail an then click to recover)', function () {
        Notification::fake();

        $user = getRandomUser();

        $this->postJson('/api/forgot-password', [
            'email' => $user->email
        ])->assertStatus(200);

        $token = '';
        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use (&$token) {
            $token = $notification->token;
            return true;
        });

        $this->postJson('/api/reset-password', [
            'email'                 => $user->email,
            'password'              => 'new-pass',
            'password_confirmation' => 'new-pass',
            'token'                 => $token,
        ])->assertStatus(200)
        ->assertJsonPath('success', true);
    });


    it('should delete the account of the user', function () {
        actingAsUser();

        $response = $this->deleteJson('/api/user/delete', [
            'password' => 'password'
        ]);

        $response->assertStatus(200)
            ->assertJson(fn ($json) =>
                $json->hasAll(['success', 'message'])
                    ->where('success', true)
                    ->where('message', 'Conta excluída com sucesso!')
                    ->has('data')
            );
    });
});