<?php namespace App\Http\Controllers\Api;

use App\Models\Repositories\SymptomRepository;
use App\Http\Controllers\Controller;

class SymptomController extends Controller
{

    protected $symptomRepository;

    public function __construct(SymptomRepository $symptomRepository)
    {
        $this->symptomRepository = $symptomRepository;
    }

    public function index()
    {
        $symptoms = $this->symptomRepository->all();

        return response()->json(array(
            'error' => false,
            'result' => $symptoms->toArray()),
            200
        );

    }


}
