<?php

use Illuminate\Support\Facades\Http;

function fakeViaCepSingle()
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

function fakeViaCepMultiple()
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
