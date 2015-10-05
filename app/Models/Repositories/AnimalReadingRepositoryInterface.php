<?php namespace App\Models\Repositories;

interface AnimalReadingRepositoryInterface extends AbstractRepositoryInterface
{

    public function getReadingUploadValidator($input);

    public function readingUpload($input, $user);
    
}

?>
