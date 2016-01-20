<?php namespace App\Models\Repositories;

interface VetRepositoryInterface extends AbstractRepositoryInterface
{

    public function getByEmailForLogin($email);

    public function getLoginValidator($input);

    public function getUnassignedPets($vet);

}

?>
