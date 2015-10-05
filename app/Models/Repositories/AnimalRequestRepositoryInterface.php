<?php namespace App\Models\Repositories;

interface AnimalRequestRepositoryInterface extends AbstractRepositoryInterface
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

    public function getByAnimalId($animalId);

    public function removeByAnimalId($animalId);

    public function getByUserId($userId);

    public function getByVetAndAnimalId($vetId, $animalId);

    public function removeByVetAndUserId($vetId, $userId);


}

?>
