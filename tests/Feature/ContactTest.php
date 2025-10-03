<?php

use App\Models\User;
use Laravel\Sanctum\Sanctum;

it('cria um contato autenticado', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $payload = [
        'user_id'    => $user->id,
        'name'       => 'Contato 1',
        'cpf'        => '12345678900',
        'phone'      => '11999999999',
        'address'    => 'Rua Exemplo',
        'complement' => null,
        'cep'        => '82840999',
        'number'     => '1222',
        'city'       => 'São Paulo',
        'state'      => 'SP',
        'latitude'   => '-45.67324',
        'longitude'  => '-45.23467',
    ];

    $response = $this->postJson('/api/contact/create', $payload);

    $response->assertStatus(201)
             ->assertJson([
                 'success' => true,
                 'message' => 'Contato \'Contato 1\' cadastrado com sucesso!'
             ]);

    $this->assertDatabaseHas('contacts', ['cpf' => '12345678900']);
});
