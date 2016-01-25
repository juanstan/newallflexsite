<?php namespace App\Models\Repositories;

interface PetConditionRepositoryInterface extends AbstractRepositoryInterface
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

    public function removeAndUpdateConditions($petId, $conditions);
    public function softDelete($petId, $condition_id);
    
}

?>
