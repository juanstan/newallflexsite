<?php namespace App\Http\Controllers\Api;

use App\Models\Entities\Condition;

class ConditionController extends \App\Http\Controllers\Controller
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
