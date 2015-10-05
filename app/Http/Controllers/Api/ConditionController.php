<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Repositories\ConditionRepository;

class ConditionController extends Controller
{
    protected $conditionRespository;

    public function __construct(ConditionRepository $conditionRespository)
    {
        $this->conditionRespository = $conditionRespository;
    }

    public function index()
    {
        $breed = $this->conditionRespository->all();

        return response()->json(array(
            'error' => false,
            'result' => $breed->toArray()),
            200
        );

    }


}
