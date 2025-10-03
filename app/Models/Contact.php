<?php

namespace App\Models;

use App\DTO\Contact\CreateContactDTO;
use App\DTO\Contact\ListContactDTO;
use App\DTO\Contact\UpdateContactDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Exception;

class Contact extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'contacts';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'cpf',
        'phone',
        'address',
        'complement',
        'cep',
        'number',
        'city',
        'state',
        'latitude',
        'longitude'
    ];

    /**
     * @param  ListContactDTO $contactDTO
     * @return Collection
     */
    public function findContactBy(ListContactDTO $contactDTO): Collection
    {
        $name = $contactDTO->name ?? '';
        $cpf  = $contactDTO->cpf  ?? '';

        try {
            $contactsList = self::where('user_id', Auth::user()->id)
                ->where(function ($query) use ($name, $cpf) {
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
     * @return self|false
     */
    public function createContact(CreateContactDTO $contactDTO): self|false
    {
        $user = Auth::user();

        try {
            $checkIfExists = self::where(function ($query) use ($contactDTO) {
                $query->where('name', 'ILIKE', "%".strtolower($contactDTO->name)."%");
                $query->orWhere('cpf', 'ILIKE', "%".$contactDTO->cpf."%");
            })->count();

            if ($checkIfExists) return false;

            $contactCreated = self::create([
                'user_id'    => $user->id,
                'name'       => $contactDTO->name,
                'cpf'        => $contactDTO->cpf,
                'phone'      => $contactDTO->phone,
                'address'    => $contactDTO->address,
                'complement' => $contactDTO->complement,
                'cep'        => $contactDTO->cep,
                'number'     => $contactDTO->number,
                'city'       => $contactDTO->city,
                'state'      => $contactDTO->state,
                'latitude'   => $contactDTO->latitude,
                'longitude'  => $contactDTO->longitude
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
     * @return self|false
     */
    public function updateContact(string|int $id, UpdateContactDTO $contactDTO): self|false
    {
        try {
            $contact = self::find($id);

            if (!$contact) return false;

            $contact->update([
                'name'       => $contactDTO->name       ?? $contact->name,
                'cpf'        => $contactDTO->cpf        ?? $contact->cpf,
                'phone'      => $contactDTO->phone      ?? $contact->phone,
                'address'    => $contactDTO->address    ?? $contact->address,
                'complement' => $contactDTO->complement ?? $contact->complement,
                'cep'        => $contactDTO->cep        ?? $contact->cep,
                'number'     => $contactDTO->number     ?? $contact->number,
                'city'       => $contactDTO->city       ?? $contact->city,
                'state'      => $contactDTO->state      ?? $contact->state,
                'latitude'   => $contactDTO->latitude   ?? $contact->latitude,
                'longitude'  => $contactDTO->longitude  ?? $contact->longitude
            ]);
        } catch (Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return $contact;
    }

    /**
     * @param  string|int $id
     * @return boolean
     */
    public function deleteContact(string|int $id): bool
    {
        try {
            $contact = self::find($id);

            if (!$contact) return false;

            $contactDeleted = $contact->delete();
        } catch (Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return $contactDeleted;
    }
}
