<?php

describe('Testing basic\'s contacts functionalities', function () {
    it('should create a contact while authenticated.', function () {
        $user    = actingAsUser();
        $payload = generateRandomContactObject();

        $payload['user_id'] = $user->id;

        $response = $this->postJson('/api/contact/create', $payload);

        $response->assertStatus(201)
            ->assertJson(fn ($json) =>
                $json->hasAll(['success', 'message'])
                    ->where('success', true)
                    ->where('message', "Contato '{$payload['name']}' cadastrado com sucesso!")
                    ->has('data')
            );
    });

    it('should update a contact', function () {
        actingAsUser();

        $payload   = generateRandomContactObject();
        $contactId = getRandomContact();

        $response = $this->putJson("/api/contact/{$contactId->id}/update", $payload);

        $response->assertStatus(200)
            ->assertJson(fn ($json) =>
                $json->hasAll(['success', 'message'])
                    ->where('success', true)
                    ->has('data')
            );
    });

    it('should delete a contact', function () {
        actingAsUser();

        $contactId = getRandomContact();

        $response = $this->deleteJson("/api/contact/{$contactId->id}/delete");

        $response->assertStatus(200)
            ->assertJson(fn ($json) =>
                $json->hasAll(['success', 'message'])
                    ->where('success', true)
                    ->where('message', 'Contato excluído com sucesso!')
                    ->has('data')
            );
    });
});

