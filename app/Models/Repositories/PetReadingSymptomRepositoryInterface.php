<?php namespace App\Models\Repositories;

interface PetReadingSymptomRepositoryInterface extends AbstractRepositoryInterface
{
    public function softDeleted($reading_id, $symptom_id);

}

?>
