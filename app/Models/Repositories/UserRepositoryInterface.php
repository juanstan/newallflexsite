<?php namespace App\Models\Repositories;

interface UserRepositoryInterface extends AbstractRepositoryInterface
{

    public function findByProviderOrCreateApi($userData, $provider);

    public function checkIfProviderNeedsUpdatingApi($userData, $user);

    public function findByProviderOrCreate($userData, $provider);

    public function checkIfProviderNeedsUpdating($userData, $user);

    public function getByEmailForLogin($email_address);

    public function getLoginValidator($input);
    
    public function getUpdateValidator($input, $id = null);

    public function getPasswordCheckValidator($password, $userPassword);

}

?>
