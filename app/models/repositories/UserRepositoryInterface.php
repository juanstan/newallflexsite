<?php namespace Repositories;

interface UserRepositoryInterface extends AbstractRepositoryInterface
{
    /**
    * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
    * @return \Entities\User
    */
    public function getByEmailForLogin($email_address);

    /**
    * @returns Validator
    */
    public function getLoginValidator($input);
    
    public function getUpdateValidator($input, $id = null);
    

    /**
    * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
    * @return \Entities\User
    */
}

?>
