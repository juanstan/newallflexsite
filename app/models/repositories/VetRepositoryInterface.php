<?php namespace Repositories;

interface VetRepositoryInterface extends AbstractRepositoryInterface
{

    public function getByEmailForLogin($email);

    public function getLoginValidator($input);

}

?>
