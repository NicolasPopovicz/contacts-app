<?php

namespace App\External;

use App\DTO\Contact\AddressSearchDTO;
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
        $url = "https://viacep.com.br/ws/{$query}/json/";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
        ));

        try {
            $response = curl_exec($curl);

            if ($response === false) {
                $error = curl_error($curl);
                curl_close($curl);
                dd($error);
            }

            curl_close($curl);

            $response = json_decode($response, true);
        } catch (Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return $response;
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