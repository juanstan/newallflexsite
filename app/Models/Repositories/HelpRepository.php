<?php namespace App\Models\Repositories;

use Validator;
use App\Models\Entities\Help;

class HelpRepository extends AbstractRepository implements HelpRepositoryInterface
{
    //protected $classname = 'App\Models\Entities\Help';
    protected $model;

    public function __construct(Help $model)
    {
        $this->model = $model;
    }

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
