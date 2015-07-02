<?php namespace App\Models\Repositories;

interface UserRepositoryInterface extends AbstractRepositoryInterface
{

    public function getByEmailForLogin($email_address);

    public function getLoginValidator($input);
    
    public function getUpdateValidator($input, $id = null);

}

?>
