<?php

namespace App\Models;

use App\DTO\Contact\CreateContactDTO;
use App\DTO\Contact\DeleteContactDTO;
use App\DTO\Contact\ListContactDTO;
use App\DTO\Contact\UpdateContactDTO;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Throwable;

class Contact extends Model
{
    /**
     * @var string
     */
    protected $table = 'contacts';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'cpf',
        'phone',
        'address',
        'cep',
        'state',
        'latitude',
        'longitude'
    ];

    /**
     * @param  ListContactDTO $contactDTO
     * @return self
     */
    public function findContactBy(ListContactDTO $contactDTO): self
    {
        $name = $contactDTO->name ?? '';
        $cpf  = $contactDTO->cpf  ?? '';

        try {
            $contactsList = self::where(function ($query) use ($name, $cpf) {
                    if ($name) $query->where('name', 'ILIKE', "%".strtolower($name)."%");
                    if ($cpf)  $query->orWhere('cpf', 'ILIKE', "%".$cpf."%");
                })
                ->get();
        } catch (Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return $contactsList;
    }

    /**
     * @param  CreateContactDTO $contactDTO
     * @return self
     */
    public function createContact(CreateContactDTO $contactDTO): self
    {
        try {
            $contactCreated = self::create([
                'name'      => $contactDTO->name,
                'cpf'       => $contactDTO->cpf,
                'phone'     => $contactDTO->phone,
                'address'   => $contactDTO->address,
                'cep'       => $contactDTO->cep,
                'state'     => $contactDTO->state,
                'latitude'  => $contactDTO->latitude,
                'longitude' => $contactDTO->longitude
            ]);
        } catch (Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return $contactCreated;
    }

    /**
     * @param  string|integer   $id
     * @param  UpdateContactDTO $contactDTO
     * @return self
     */
    public function updateContact(string|int $id, UpdateContactDTO $contactDTO): self
    {
        try {
            $contact = self::findOrFail($id);

            $contact->update([
                'name'      => $contactDTO->name      ?? $contact->name,
                'cpf'       => $contactDTO->cpf       ?? $contact->cpf,
                'phone'     => $contactDTO->phone     ?? $contact->phone,
                'address'   => $contactDTO->address   ?? $contact->address,
                'cep'       => $contactDTO->cep       ?? $contact->cep,
                'state'     => $contactDTO->state     ?? $contact->state,
                'latitude'  => $contactDTO->latitude  ?? $contact->latitude,
                'longitude' => $contactDTO->longitude ?? $contact->longitude
            ]);
        } catch (Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return $contact;
    }

    /**
     * @param  DeleteContactDTO $contactDTO
     * @return self
     */
    public function deleteContact(DeleteContactDTO $contactDTO): self
    {
        try {
            $contactDeleted = self::where('id', $contactDTO->id)->delete($contactDTO);
        } catch (Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return $contactDeleted;
    }
}
