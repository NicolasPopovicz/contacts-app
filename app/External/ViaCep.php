<?php

namespace App\External;

use App\DTO\Contact\AddressSearchDTO;
use Illuminate\Support\Facades\Http;
use Throwable;
use Exception;

class ViaCep
{
    /**
     * @param  AddressSearchDTO $dto
     * @return array|null
     */
    public function searchAddress(AddressSearchDTO $dto): ?array
    {
        if (empty($dto->cep)) {
            if (is_null($dto->state) || is_null($dto->city) || is_null($dto->address)) {
                return null;
            }
        }

        $query = $this->handleQuerySearch($dto);
        $url   = "https://viacep.com.br/ws/{$query}/json/";

        try {
            $response = Http::timeout(10)->get($url);

            if ($response->failed()) {
                throw new Exception('Erro ao consultar ViaCep', $response->status());
            }

            return $response->json();

        } catch (Throwable $th) {
            throw new Exception('Erro na requisição ViaCep: '.$th->getMessage(), 500);
        }
    }

    /**
     * Trata o input para que esteja no formato que o ViaCep aceita.
     * @param  AddressSearchDTO $dto
     * @return string
     */
    private function handleQuerySearch(AddressSearchDTO $dto): string
    {
        if (!empty($dto->cep)) {
            return $dto->cep;
        }

        // Monta a busca por UF / Cidade / Logradouro
        $uf       = strtoupper($dto->state ?? '');
        $cidade   = urlencode($dto->city ?? '');
        $endereco = urlencode($dto->address ?? '');

        return "{$uf}/{$cidade}/{$endereco}";
    }
}