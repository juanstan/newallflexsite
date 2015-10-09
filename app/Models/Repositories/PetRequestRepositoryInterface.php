<?php namespace App\Models\Repositories;

interface PetRequestRepositoryInterface extends AbstractRepositoryInterface
{
    /**
    * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
    * @return \Entities\User
    */

    /**
    * @returns Validator
    */

    /**
    * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
    * @return \Entities\User
    */

    public function setUser($user);

    public function getByPetId($petId);

    public function removeByPetId($petId);

    public function getByUserId($userId);

    public function getAllByUserId($userId);

    public function getByVetAndPetId($vetId, $petId);

    public function removeByVetAndUserId($vetId, $userId);

    public function removeByVetId($vetId);


}

?>
