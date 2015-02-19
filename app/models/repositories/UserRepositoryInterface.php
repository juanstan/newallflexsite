<?php namespace Repositories;

interface UserRepositoryInterface extends AbstractRepositoryInterface
{
    /**
    * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
    * @return \Entities\User
    */
    public function getByEmailForLogin($email);

    /**
    * @returns Validator
    */
    public function getLoginValidator($input);
    

    /**
    * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
    * @return \Entities\User
    */
}

?>
