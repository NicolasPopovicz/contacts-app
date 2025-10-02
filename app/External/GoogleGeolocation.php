<?php

namespace App\External;

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

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$encoded}&key={$this->apiKey}";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exception('Erro na requisição Google Geocoding: '.curl_error($curl));
        }

        curl_close($curl);

        $data = json_decode($response, true);

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
        $multiHandle = curl_multi_init();
        $curlHandles = [];

        // Prepara cada requisição
        foreach ($addresses as $idx => $addr) {
            $encoded = urlencode($addr);
            $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$encoded}&key={$this->apiKey}";

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 8,
            ]);

            curl_multi_add_handle($multiHandle, $ch);
            $curlHandles[$idx] = $ch;
        }

        // Executa em paralelo
        do {
            curl_multi_exec($multiHandle, $running);

            if ($running) {
                curl_multi_select($multiHandle);
            }
        } while ($running > 0);

        // Coleta as respostas
        $results = [];
        foreach ($curlHandles as $idx => $ch) {
            $response = curl_multi_getcontent($ch);
            $data = json_decode($response, true);

            if (isset($data['status']) && $data['status'] === 'OK' && !empty($data['results'][0])) {
                $location = $data['results'][0]['geometry']['location'];
                $results[$idx] = [
                    'latitude'  => $location['lat'],
                    'longitude' => $location['lng'],
                ];
            } else {
                $results[$idx] = null;
            }

            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }

        curl_multi_close($multiHandle);

        return $results;
    }
}
