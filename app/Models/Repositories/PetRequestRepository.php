<?php namespace App\Models\Repositories;

use Validator;
use App\Models\Entities\Pet\Request;
use Carbon\Carbon;

class PetRequestRepository extends AbstractRepository implements PetRequestRepositoryInterface
{
    protected $model;
    protected $user;

    public function __construct(Request $model, UserRepositoryInterface $user)
    {
        $this->userRepo = $user;
        $this->model = $model;
    }

    public function setUser($user)
    {
        $this->user = is_numeric($user) ? $this->userRepo->get($user) : $user;

        return $this;
    }

    public function getByPetId($petId)
    {
        return $this->query()->where('pet_id', '=', $petId)->first();
    }

    public function removeByPetId($petId)
    {
        $this->query()->where('pet_id', '=', $petId)->delete();
    }

    public function getByUserId($userId)
    {
        return $this->query()->where('user_id', '=', $userId)->first();
    }

    public function getAllByUserId($userId)
    {
        return $this->query()->where('user_id', '=', $userId)->get();
    }

    public function getAllVetsByPet($petId)
    {
        return $this->query()->where('pet_id', '=', $petId)->whereNull('deleted_at') ->get();
    }

    public function getVetsByPets($pets)
    {
        return $this->query()
            ->whereIn('pet_id', $pets)
            ->groupby('vet_id')
            ->get();
    }


    public function getAllByVetId($vetId)
    {
        return $this->query()->where('vet_id', '=', $vetId)->get();
    }

    public function getByVetAndPetId($vetId, $petId)
    {
        return $this->query()->where('vet_id', '=', $vetId)->where('pet_id', $petId)->first();
    }

    public function getApprovedByVetAndPetId($vetId, $petId)
    {
        return $this->query()->where('vet_id', '=', $vetId)->where('pet_id', $petId)->where('approved', '=', 1)->get();
    }

    public function removeByVetAndUserId($vetId, $userId)
    {
        $this->query()->where('vet_id', '=', $vetId)->where('user_id', $userId)->delete();
    }

    public function removeByVetId($vetId)
    {
        $this->query()->where('vet_id', '=', $vetId)->delete();
    }

    public function getCreateValidator($input)
    {
        return Validator::make($input,
        [
            'vet_id'        => ['required'],
            'approved'     	=> ['required']
        ]);
    }

    public function getUpdateValidator($input)
    {
        return Validator::make($input,
        [
        ]);
    }


    public function updateState($key, $input) {

        return $this->user
                ->pets()
                ->findOrFail($key['pet_id'])
                ->vet()
                ->updateExistingPivot($key['vet_id'], $input);

    }

   
}

?>
