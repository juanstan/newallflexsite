<?php namespace App\Models\Repositories;

interface ConditionRepositoryInterface extends AbstractRepositoryInterface
{
    public function getCreateValidator($input);

    public function getUpdateValidator($input);

}

?>
