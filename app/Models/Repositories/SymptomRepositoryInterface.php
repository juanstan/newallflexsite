<?php namespace App\Models\Repositories;

interface SymptomRepositoryInterface extends AbstractRepositoryInterface
{
    public function getCreateValidator($input);

    public function getUpdateValidator($input);

}

?>
