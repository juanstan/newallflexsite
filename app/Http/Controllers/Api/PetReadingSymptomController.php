<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use URL;

use App\Models\Repositories\PetReadingSymptomRepositoryInterface;
use App\Models\Repositories\PetRepositoryInterface;
use App\Models\Repositories\PetReadingRepositoryInterface;
use App\Http\Controllers\Controller;

class PetReadingSymptomController extends Controller
{

    protected $authUser;

    protected $petReadingRepository;

    protected $petRepository;

    protected $petReadingSymptomRepository;

    public function __construct(PetReadingRepositoryInterface $petReadingRepository, PetRepositoryInterface $petRepository, PetReadingSymptomRepositoryInterface $petReadingSymptomRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->petReadingSymptomRepository = $petReadingSymptomRepository;
        $this->petRepository = $petRepository;
        $this->petReadingRepository = $petReadingRepository;
    }

    public function index($pet_id, $reading_id)
    {

        $this->petRepository->setUser($this->authUser);
        $pet = $this->petRepository->get($pet_id);
        $this->petReadingRepository->setPet($pet);
        $reading = $this->petReadingRepository->get($reading_id);
        $this->petReadingSymptomRepository->setReading($reading);

        $result = [];

        foreach ($this->petReadingSymptomRepository->all() as $symptom){
            $result[] = array(
                'id'            => $symptom->id,
                'reading_id'    => $symptom->pivot->reading_id,
                'symptom_id'    => $symptom->pivot->symptom_id,
                'name'          => $symptom->name,
                'created_at'    => $symptom->pivot->created_at->toDateTimeString(),
                'updated_at'    => $symptom->pivot->updated_at->toDateTimeString()
            );
        }
        return response()->json(['error' => false,
            'result' => $result]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($pet_id, $reading_id) // POST
    {

        $this->petRepository->setUser($this->authUser);
        $pet = $this->petRepository->get($pet_id);
        $this->petReadingRepository->setPet($pet);
        $reading = $this->petReadingRepository->get($reading_id);
        $this->petReadingSymptomRepository->setReading($reading);

        $input = Input::all();
        $input['reading_id'] = $reading_id;
        $validator = $this->petReadingSymptomRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $this->petReadingRepository->addSymptom($input);
        return response()->json(['error' => false, 'result' => $reading]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($pet_id, $reading_id, $id) // GET
    {
        $this->petRepository->setUser($this->authUser);
        $pet = $this->petRepository->get($pet_id);
        $this->petReadingRepository->setPet($pet);
        $reading = $this->petReadingRepository->get($reading_id);
        $this->petReadingSymptomRepository->setReading($reading);


        return response()->json(['error' => false,
            'result' => $this->petReadingSymptomRepository->get($id)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($pet_id, $reading_id, $id) // PUT
    {

        $this->petRepository->setUser($this->authUser);

        $pet = $this->petRepository->get($pet_id);

        $this->petReadingRepository->setPet($pet);

        $reading = $this->petReadingRepository->get($reading_id);

        $this->petReadingSymptomRepository->setReading($reading);

        $input = Input::all();

        $validator = $this->petReadingSymptomRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->petReadingSymptomRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return response()->json(['error' => false,
            'result' => $this->petReadingSymptomRepository->get($id)]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($pet_id, $reading_id, $id) // DELETE
    {

        try {
            $this->petRepository->setUser($this->authUser);
            $this->petRepository->softDeleteSymptomForReading($pet_id, $reading_id, $id);
            return response()->json(['error'=> false]);

        } catch (\Exception $e) {
            return response()->json(['error'=> true, 'message'=>$e->getMessage()]);

        }

    }


}
