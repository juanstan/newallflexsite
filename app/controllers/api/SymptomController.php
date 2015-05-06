<?php  namespace Api;

use Entities\SymptomNames;

class SymptomController extends \BaseController {

    public function index()
    {
        $symptoms = SymptomNames::all();

        return \Response::json(array(
            'error' => false,
            'result' => $symptoms->toArray()),
            200
        );

    }


}
