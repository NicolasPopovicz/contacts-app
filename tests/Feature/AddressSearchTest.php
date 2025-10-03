<?php

beforeEach(function () {
    config()->set('services.google.geocoding_key', 'fake-api-key-for-tests');
});

describe('Testing address searches in various ', function () {
    it('search address by postcode', function () {
        actingAsUser();
        fakeViaCepSingle();

        $response = $this->getJson('/api/address/search?cep=01001000');

        $response->assertStatus(200)
            ->assertJson(fn ($json) =>
                $json->hasAll(['success', 'message'])
                    ->where('success', true)
                    ->has('data')
                    ->etc()
            );
    });

    it('search address by state/city/address and returning multiple options', function () {
        actingAsUser();
        fakeViaCepMultiple();

        $response = $this->getJson('/api/address/search?state=SP&city=Sao%20Paulo&address=Praca%20da%20Se');

        $response->assertStatus(200)
            ->assertJson(fn ($json) =>
                $json->hasAll(['success', 'message'])
                    ->where('success', true)
                    ->has('data', 3)
                    ->has('data.0.cep')
                    ->has('data.1.cep')
                    ->has('data.2.cep')
            );
    });
});
