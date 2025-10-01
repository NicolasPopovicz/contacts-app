<?php

namespace App\Services;

use App\DTO\Contact\CreateContactDTO;
use App\DTO\Contact\DeleteContactDTO;
use App\DTO\Contact\ListContactDTO;
use App\DTO\Contact\UpdateContactDTO;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactService
{
    public function __construct(private Contact $contactModel)
    {
        $this->contactModel = $contactModel;
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
     * @param  string|int $id
     * @return boolean
     */
    public function delete(string|int $id): bool
    {
        return $this->contactModel->deleteContact($id);
    }
}