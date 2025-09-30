<?php

namespace App\Services;

use App\DTO\Contact\CreateContactDTO;
use App\DTO\Contact\DeleteContactDTO;
use App\DTO\Contact\ListContactDTO;
use App\DTO\Contact\UpdateContactDTO;
use App\Models\Contact;
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
    public function list(ListContactDTO $contactDTO): Contact
    {
        $contacts = $this->contactModel->findContactBy($contactDTO);

        return $contacts;
    }

    /**
     * @param  CreateContactDTO $contactDTO
     * @return Contact
     */
    public function create(CreateContactDTO $contactDTO): Contact
    {
        $create = $this->contactModel->createContact($contactDTO);

        return $create;
    }

    /**
     * @param  string|integer   $id
     * @param  UpdateContactDTO $contactDTO
     * @return Contact
     */
    public function update(string|int $id, UpdateContactDTO $contactDTO): Contact
    {
        $update = $this->contactModel->updateContact($id, $contactDTO);

        return $update;
    }

    /**
     * @param  DeleteContactDTO $contactDTO
     * @return Contact
     */
    public function delete(DeleteContactDTO $contactDTO): Contact
    {
        $delete = $this->contactModel->deleteContact($contactDTO);

        return $delete;
    }

    /**
     * @param  boolean $success
     * @param  string  $message
     * @param  mixed   $data
     * @return JsonResponse
     */
    public function handleReturn(bool $success = true, string $message = '', mixed $data = null): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ]);
    }
}