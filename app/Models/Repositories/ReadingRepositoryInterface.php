<?php namespace App\Models\Repositories;

interface ReadingRepositoryInterface extends AbstractRepositoryInterface
{
    public function getCreateValidator($input);

    public function getUpdateValidator($input);

}

?>
