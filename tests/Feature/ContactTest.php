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

    it('should list contacts', function () {
        actingAsUser();

        $response = $this->getJson('/api/contacts/list');

        $response->assertStatus(200)
            ->assertJson(fn ($json) =>
                $json->hasAll(['success', 'message', 'data'])
                    ->where('success', true)
                    ->where('message', 'Listagem de contatos obtida com sucesso!')
                    ->has('data')
            );
    });

    it('should search a contact by its name', function () {
        $user = actingAsUser();

        createRandomContacts($user->id);

        $contact = getRandomContact($user->id);

        // Filtra por nome
        $response = $this->getJson("/api/contacts/list?name={$contact->name}");
        $response->assertStatus(200)
            ->assertJson(fn ($json) =>
                $json->where('success', true)
                    ->where('message', 'Listagem de contatos obtida com sucesso!')
                    ->has('data', 1)
                    ->where('data.0.name', $contact->name)
            );

    });

    it('should search a contact by its document (cpf)', function () {
        $user = actingAsUser();

        createRandomContacts($user->id);

        $contact = getRandomContact($user->id);

        // Filtra por CPF
        $response = $this->getJson("/api/contacts/list?cpf={$contact->cpf}");
        $response->assertStatus(200)
            ->assertJson(fn ($json) =>
                $json->where('success', true)
                    ->where('message', 'Listagem de contatos obtida com sucesso!')
                    ->has('data', 1)
                    ->where('data.0.cpf', $contact->cpf)
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

