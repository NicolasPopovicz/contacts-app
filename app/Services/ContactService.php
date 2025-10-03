<?php

namespace App\Services;

use App\DTO\Contact\AddressSearchDTO;
use App\DTO\Contact\CreateContactDTO;
use App\DTO\Contact\ListContactDTO;
use App\DTO\Contact\UpdateContactDTO;
use App\External\GoogleGeolocation;
use App\External\ViaCep;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;

class ContactService
{
    public function __construct(
        private Contact $contactModel,
        private ViaCep $viaCepExternal
    )
    {
        $this->contactModel   = $contactModel;
        $this->viaCepExternal = $viaCepExternal;
    }

    /**
     * @param  ListContactDTO $contactDTO
     * @return Contact
     */
    public function list(ListContactDTO $contactDTO): Collection
    {
        return $this->contactModel->findContactBy($contactDTO);
    }

    /**
     * @param  CreateContactDTO $contactDTO
     * @return Contact|false
     */
    public function create(CreateContactDTO $contactDTO): Contact|false
    {
        return $this->contactModel->createContact($contactDTO);
    }

    /**
     * @param  string|integer   $id
     * @param  UpdateContactDTO $contactDTO
     * @return Contact|false
     */
    public function update(string|int $id, UpdateContactDTO $contactDTO): Contact|false
    {
        return $this->contactModel->updateContact($id, $contactDTO);
    }

    /**
     * @param  AddressSearchDTO $dto
     * @return array|null
     */
    public function searchAddr(AddressSearchDTO $dto): ?array
    {
        $addresses   = $this->viaCepExternal->searchAddress($dto);
        $geolocation = new GoogleGeolocation();

        if (is_null($addresses) || array_key_exists('erro', $addresses)) {
            return null;
        }

        if (array_key_exists('cep', $addresses)) {
            $enderecoCompleto = "{$addresses['logradouro']}, {$addresses['bairro']}, {$addresses['localidade']} - {$addresses['uf']}";
            $coords = $geolocation->getCoordinates($enderecoCompleto);

            if ($coords && gettype($coords) === 'array') {
                $addresses['latitude']  = $coords['latitude'];
                $addresses['longitude'] = $coords['longitude'];
            }

            return $addresses;
        }

        if (is_array($addresses) && count($addresses) > 1) {
            $queryList = [];

            foreach ($addresses as $idx => $addr) {
                $queryList[$idx] = "{$addr['logradouro']}, {$addr['bairro']}, {$addr['localidade']} - {$addr['uf']}";
            }

            $coordsList = $geolocation->getCoordinatesBatch($queryList);

            foreach ($coordsList as $idx => $coords) {
                if ($coords) {
                    $addresses[$idx]['latitude']  = $coords['latitude'];
                    $addresses[$idx]['longitude'] = $coords['longitude'];
                }
            }
        }

        return $addresses;
    }

    /**
     * @param  string|int $id
     * @return boolean
     */
    public function delete(string|int $id): bool
    {
        return $this->contactModel->deleteContact($id);
    }
}