<?php

namespace App\Http\Controllers;

use App\DTO\Contact\AddressSearchDTO;
use App\DTO\Contact\CreateContactDTO;
use App\DTO\Contact\ListContactDTO;
use App\DTO\Contact\UpdateContactDTO;
use App\Http\Requests\Contact\AddressRequest;
use App\Http\Requests\Contact\CreateContactRequest;
use App\Http\Requests\Contact\ListContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Services\ContactService;
use Illuminate\Http\Request;
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

        $return = empty($contactsLists)
            ? [true, "Não há contatos para listar.", [], 200]
            : [true, "Listagem de contatos obtida com sucesso!", $contactsLists, 200];

        return $this->handleReturn(...$return);
    }

    /**
     * @param  CreateContactRequest $req
     * @return JsonResponse
     */
    public function store(CreateContactRequest $req): JsonResponse
    {
        $dto = CreateContactDTO::fromRequest($req);

        $contactCreated = $this->contactService->create($dto);

        $return = !$contactCreated
            ? [false, "Já existe um contato com estes dados.", ['name' => $dto->name, 'cpf' => $dto->cpf], 400]
            : [true, "Contato '{$dto->name}' cadastrado com sucesso!", $contactCreated, 201];

        return $this->handleReturn(...$return);
    }

    /**
     * @param  UpdateContactRequest $req
     * @param  string|integer       $id
     * @return JsonResponse
     */
    public function update(UpdateContactRequest $req, string|int $id): JsonResponse
    {
        $dto = UpdateContactDTO::fromRequest($req);

        $contactUpdated = $this->contactService->update($id, $dto);

        $return = !$contactUpdated
            ? [false, "Não foi possível encontrar o contato com os dados fornecidos.", [], 400]
            : [true, "Contato '{$dto->name}' cadastrado com sucesso!", $contactUpdated, 200];

        return $this->handleReturn(...$return);
    }

    /**
     * @param  AddressRequest $req
     * @return JsonResponse
     */
    public function searchContactAddress(AddressRequest $req): JsonResponse
    {
        $dto = AddressSearchDTO::fromRequest($req);

        $addresses = $this->contactService->searchAddr($dto);

        $return = !$addresses
            ? [false, "Não foi possível encontrar o endereço com os dados fornecidos.", [], 400]
            : [true, "Lista de endereços carregada com sucesso!", $addresses, 200];

        return $this->handleReturn(...$return);
    }

    /**
     * @param  string|int $id
     * @return JsonResponse
     */
    public function destroy(string|int $id): JsonResponse
    {
        if (!preg_match("/^\d+$/", $id)) {
            return $this->handleReturn(false, "Parâmetro inválido", [], 400);
        }

        $contactDeleted = $this->contactService->delete($id);

        $return = !$contactDeleted
            ? [false, "Não foi possível encontrar o contato com os dados fornecidos.", [], 400]
            : [true, "Contato excluído com sucesso!", $contactDeleted, 200];

        return $this->handleReturn(...$return);
    }
}
