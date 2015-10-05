<?php namespace App\Models\Repositories;

interface SensorReadingRepositoryInterface extends AbstractRepositoryInterface
{
    public function getCreateValidator($input);

    public function getUpdateValidator($input);

}

?>
