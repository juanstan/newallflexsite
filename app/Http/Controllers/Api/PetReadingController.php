<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use Lang;
use URL;

use App\Models\Entities\Pet;
use App\Models\Entities\SensorReading;
use App\Models\Repositories\PetReadingRepositoryInterface;
use App\Models\Repositories\PetRepositoryInterface;
use App\Http\Controllers\Controller;

class PetReadingController extends Controller
{

    protected $authUser;
    protected $petReadingRepository;
    protected $petRepository;

    public function __construct(PetReadingRepositoryInterface $petReadingRepository, PetRepositoryInterface $petRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->petReadingRepository = $petReadingRepository;
        $this->petRepository = $petRepository;
    }

    public function index($pet_id)
    {

        $this->petRepository->setUser($this->authUser);

        $pet = $this->petRepository->get($pet_id);

        $this->petReadingRepository->setPet($pet);

        return response()->json(['error' => false,
            'result' => $this->petReadingRepository->all()]);

    }

    public function store($pet_id) // POST
    {

        $this->petRepository->setUser($this->authUser);

        $pet = $this->petRepository->get($pet_id);

        $this->petReadingRepository->setPet($pet);



        $input = Input::all();
        $input['pet_id'] = $pet_id;


        $validator = $this->petReadingRepository->getCreateValidator($input);


        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }



        $reading = $this->petReadingRepository->create($input);



        if ($reading == null) {
            \App::abort(500);
        }

        return response()->json(['error' => false, 'result' => $reading], 201)
            ->header('Location', URL::route('api.pet.{pet_id}.reading.show', [$reading->id]));

    }

    public function show($pet_id, $id) // GET
    {
        $this->petRepository->setUser($this->authUser);

        $pet = $this->petRepository->get($pet_id);

        $this->petReadingRepository->setPet($pet);

        return response()->json(['error' => false,
            'result' => $this->petReadingRepository->get($id)]);
    }

    public function update($pet_id, $id) // PUT
    {

        $this->petRepository->setUser($this->authUser);

        $pet = $this->petRepository->get($pet_id);

        $this->petReadingRepository->setPet($pet);

        $input = Input::all();

        $validator = $this->petReadingRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->petReadingRepository->update($id, $input) == false) {

            \App::abort(500);
        }

        return response()->json(['error' => false,
            'result' => $this->petReadingRepository->get($id)]);
    }

    public function postAssign($pet_id)
    {
        $newPetId = Input::get('pet_id');
        $query = $this->petRepository->get($pet_id);
        $data['microchip_number'] = $query->microchip_number;
        if ($this->petRepository->update($newPetId, $data)) {
            $this->petRepository->delete($pet_id);
            $sensorReading = $this->sensorReadingRepository->getByPetId($pet_id);
            $this->sensorReadingRepository->update($sensorReading->id, array('pet_id' => $newPetId));
        }
        return response()->json(['error' => false,
            'result' => Lang::get('general.Pet microchip number assigned')]);
    }


}
