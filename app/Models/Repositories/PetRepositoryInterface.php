<?php namespace App\Models\Repositories;

interface PetRepositoryInterface extends AbstractRepositoryInterface
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
    public function petsSet();
    public function microchipUnassigned();
    public function UpdatingAttributePivot($vet_id, $pet_id, $data);
    public function getVetAssignedMyPets($pets);
    public function attachDetachPetToMyVets($iPetID);
    public function attachDetachVet($vet_id,$attach);

}

?>
