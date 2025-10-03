<?php

namespace App\External;

use Illuminate\Support\Facades\Http;
use Exception;

class GoogleGeolocation
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.google.geocoding_key');
    }

    /**
     * @param  string $address
     * @return array|null
     */
    public function getCoordinates(string $address): ?array
    {
        $encoded = urlencode($address);
        $url     = "https://maps.googleapis.com/maps/api/geocode/json?address={$encoded}&key={$this->apiKey}";

        $response = Http::timeout(20)->get($url);

        if ($response->failed()) {
            throw new Exception('Erro na requisição Google Geocoding: '.$response->status());
        }

        $data = $response->json();

        if (($data['status'] ?? '') !== 'OK' || empty($data['results'][0])) {
            return null;
        }

        $location = $data['results'][0]['geometry']['location'];

        return [
            'latitude'  => $location['lat'],
            'longitude' => $location['lng'],
        ];
    }

    /**
     * Obtém as coordenadas de uma lista de endereços em paralelo.
     * @param  array
     * @return array
     */
    public function getCoordinatesBatch(array $addresses): array
    {
        $results = [];

        // Monta um array de Promises
        $promises = collect($addresses)->map(function ($addr) {
            $encoded = urlencode($addr);
            $url     = "https://maps.googleapis.com/maps/api/geocode/json?address={$encoded}&key={$this->apiKey}";

            // com pool (assíncrono)
            return Http::async()->timeout(8)->get($url);
        });

        // Aguarda todas as requisições
        $responses = $promises->map(fn($promise) => $promise->wait());

        // Processa cada resposta
        foreach ($responses as $idx => $response) {
            if ($response->failed()) {
                $results[$idx] = null;
                continue;
            }

            $data = $response->json();

            if (isset($data['status']) && $data['status'] === 'OK' && !empty($data['results'][0])) {
                $location = $data['results'][0]['geometry']['location'];
                $results[$idx] = [
                    'latitude'  => $location['lat'],
                    'longitude' => $location['lng'],
                ];
            } else {
                $results[$idx] = null;
            }
        }

        return $results;
    }
}
