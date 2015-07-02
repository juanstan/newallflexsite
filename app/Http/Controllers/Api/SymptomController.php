<?php namespace App\Http\Controllers\Api;

use App\Models\Entities\Symptom;

class SymptomController extends \App\Http\Controllers\Controller
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
