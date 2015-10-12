<?php namespace App\Models\Repositories;

use Validator;

class PetRequestRepository extends AbstractRepository implements PetRequestRepositoryInterface
{
    protected $classname = 'App\Models\Entities\Pet\Request';

    protected $repository;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->user = $userRepositoryInterface;
    }

    public function setUser($user)
    {
        $this->user = is_numeric($user) ? $this->repository->get($user) : $user;

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
        ]);
    }

    public function getUpdateValidator($input)
    {
        return Validator::make($input,
        [
        ]);
    }

   
}

?>
