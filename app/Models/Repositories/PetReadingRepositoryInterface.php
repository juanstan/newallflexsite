<?php namespace App\Models\Repositories;

interface PetReadingRepositoryInterface extends AbstractRepositoryInterface
{

    public function getReadingUploadValidator($input);

    public function readingUpload($input, $user);
    
}

?>
