<?php

namespace App\Http\Controllers;

use App\DTO\Contact\CreateContactDTO;
use App\DTO\Contact\DeleteContactDTO;
use App\DTO\Contact\ListContactDTO;
use App\DTO\Contact\UpdateContactDTO;
use App\Http\Requests\Contact\CreateContactRequest;
use App\Http\Requests\Contact\DeleteContactRequest;
use App\Http\Requests\Contact\ListContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Services\ContactService;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactController extends Controller
{
    public function __construct(protected ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * @param  ListContactRequest $req
     * @return JsonResponse
     */
    public function index(ListContactRequest $req): JsonResponse
    {
        $dto = ListContactDTO::fromRequest($req);

        $contactsLists = $this->contactService->list($dto);

        return response()->json([
            'success' => true,
            'message' => 'Lista de contatos',
            'data'    => $contactsLists
        ], 200);
    }

    /**
     * @param  CreateContactRequest $req
     * @return JsonResponse
     */
    public function store(CreateContactRequest $req): JsonResponse
    {
        $dto = CreateContactDTO::fromRequest($req);

        $this->contactService->create($dto);

        return response()->json([
            'message' => 'create'
        ], 201);
    }

    /**
     * @param  UpdateContactRequest $req
     * @param  string|integer       $id
     * @return JsonResponse
     */
    public function update(UpdateContactRequest $req, string|int $id): JsonResponse
    {
        $dto = UpdateContactDTO::fromRequest($req);

        $this->contactService->update($id, $dto);

        return response()->json([
            'message' => 'update'
        ], 201);
    }

    /**
     * @param  DeleteContactRequest $req
     * @return JsonResponse
     */
    public function destroy(DeleteContactRequest $req): JsonResponse
    {
        $dto = DeleteContactDTO::fromRequest($req);

        $this->contactService->delete($dto);

        return response()->json([
            'message' => 'destroy'
        ], 200);
    }
}
