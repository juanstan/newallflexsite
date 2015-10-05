<?php namespace App\Models\Repositories;

interface BreedRepositoryInterface extends AbstractRepositoryInterface
{
    public function getCreateValidator($input);

    public function getUpdateValidator($input);

}

?>
