<?php namespace App\Http\Controllers\Api;

use App\Models\Entities\Breed;

class BreedController extends \App\Http\Controllers\Controller
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
