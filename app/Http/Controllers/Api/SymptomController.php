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

    public function index($pet_id = false, $reading_id = false)
    {

        try {
            //request: /api/symptoms
            if (!$pet_id && !$reading_id) {
                $symptoms = $this->symptomRepository->all();

            } else { //request: /ap/vet/pet/{pet}/reading/{reading}/symptoms
                $symptoms = $this->symptomRepository
                    ->getAssignedReadingById(['pet_id' => $pet_id, 'reading_id' => $reading_id])
                    ->symptoms()->get();
            }

            return response()->json(array(
                'error' => false,
                'result' => $symptoms->toArray()),
                200
            );

        }catch(\Exception $e) {
            return response()->json(array(
                'error' => true,
                'message' => $e->getMessage()),
                400
            );

        }



    }

    /*public function show($pet_id, $reading_id) // GET
    {
        //set the pet, reading and get the symptoms
        $symptoms =$this->symptonRepository->setPet($pet_id)->setReading($reading_id)->symptoms();
        return response()->json(['error' => false, 'result' => $symptoms], 200);
    }*/




}
