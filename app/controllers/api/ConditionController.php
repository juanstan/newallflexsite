<?php namespace Api;

use Entities\Condition;

class BreedController extends \BaseController
{

    public function index()
    {
        $breed = Condition::all();

        return \Response::json(array(
            'error' => false,
            'result' => $breed->toArray()),
            200
        );

    }


}
