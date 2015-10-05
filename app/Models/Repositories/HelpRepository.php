<?php namespace App\Models\Repositories;

class HelpRepository extends AbstractRepository implements HelpRepositoryInterface
{
    protected $classname = 'App\Models\Entities\Help';

    public function getCreateValidator($input)
    {
        return \Validator::make($input,
            [

            ]);
    }


    public function getUpdateValidator($input)
    {
        return \Validator::make($input,
            [

            ]);
    }

}

?>
