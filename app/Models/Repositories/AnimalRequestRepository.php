<?php namespace App\Models\Repositories;

use Validator;

class AnimalRequestRepository extends AbstractRepository implements AnimalRequestRepositoryInterface
{
    protected $classname = 'App\Models\Entities\Animal\Request';

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

    public function getByAnimalId($animalId)
    {
        return $this->query()->where('animal_id', '=', $animalId)->first();
    }

    public function removeByAnimalId($animalId)
    {
        $this->query()->where('animal_id', '=', $animalId)->delete();
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

    public function getByVetAndAnimalId($vetId, $animalId)
    {
        return $this->query()->where('vet_id', '=', $vetId)->where('animal_id', $animalId)->first();
    }

    public function getApprovedByVetAndAnimalId($vetId, $animalId)
    {
        return $this->query()->where('vet_id', '=', $vetId)->where('animal_id', $animalId)->where('approved', '=', 1)->get();
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
