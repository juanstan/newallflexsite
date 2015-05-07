<?php namespace Api;

use Entities\Symptom;

class SymptomController extends \BaseController
{

    public function index()
    {
        $symptoms = Symptom::all();

        return \Response::json(array(
            'error' => false,
            'result' => $symptoms->toArray()),
            200
        );

    }


}
