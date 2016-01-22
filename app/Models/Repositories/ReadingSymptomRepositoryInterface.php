<?php namespace App\Models\Repositories;

interface ReadingSymptomRepositoryInterface extends AbstractRepositoryInterface
{
    /**
    * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
    * @return \Entities\User
    */

    /**
    * @returns Validator
    */

    /**
    * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
    * @return \Entities\User
    */

    public function removeAndUpdateSymptoms($readingId, $conditions);

    public function removeSymptomById($readingId, $symptomId);
    
}

?>
