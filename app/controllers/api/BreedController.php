<?php namespace Api;

use Entities\Breed;

class BreedController extends \BaseController
{

    public function index()
    {
        $breed = Breed::all();

        return \Response::json(array(
            'error' => false,
            'result' => $breed->toArray()),
            200
        );

    }


}
