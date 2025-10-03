<?php

use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;

function fakeViaCepSingle(): void
{
    Http::fake([
        'https://viacep.com.br/*' => Http::response([
            "cep"        => "01001-000",
            "logradouro" => "Praça da Sé",
            "bairro"     => "Sé",
            "localidade" => "São Paulo",
            "uf"         => "SP"
        ], 200)
    ]);
}

function fakeViaCepMultiple(): void
{
    Http::fake([
        'https://viacep.com.br/*' => Http::response([
            [
                "cep"         => "80010-140",
                "logradouro"  => "Praça Carlos Gomes",
                "complemento" => "",
                "bairro"      => "Centro",
                "localidade"  => "Curitiba",
                "uf"          => "PR"
            ],
            [
                "cep"         => "82530-345",
                "logradouro"  => "Praça Carlos Schott",
                "complemento" => "371",
                "bairro"      => "Tarumã",
                "localidade"  => "Curitiba",
                "uf"          => "PR"
            ],
            [
                "cep"         => "80050-300",
                "logradouro"  => "Praça Carlos Filizola",
                "complemento" => "385",
                "bairro"      => "Cristo Rei",
                "localidade"  => "Curitiba",
                "uf"          => "PR"
            ]
        ], 200)
    ]);
}

function actingAsUser()
{
    $user = User::factory()->create();
    Sanctum::actingAs($user);

    return $user;
}

function createRandomContacts($authUserId)
{
    Contact::factory()->count(5)->create([
        'user_id' => $authUserId
    ]);
}

function generateRandomUserObject(): array
{
    return User::factory()->raw();
}

function generateRandomContactObject(): array
{
    return Contact::factory()->raw();
}

function getRandomUser(): User
{
    return User::inRandomOrder()->first();
}

function getRandomContact($authUserId = null): Contact
{
    return !is_null($authUserId)
        ? Contact::where('user_id', $authUserId)->get()->first()
        : Contact::inRandomOrder()->first();
}