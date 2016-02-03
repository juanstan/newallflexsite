<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use Lang;
use URL;

use App\Models\Entities\Pet;
use App\Models\Repositories\PetReadingRepositoryInterface;
use App\Models\Repositories\PetRepositoryInterface;
use App\Models\Repositories\VetRepositoryInterface;
use App\Http\Controllers\Controller;

class PetReadingController extends Controller
{

    protected $authUser;
    protected $petReadingRepository;
    protected $petRepository;
    protected $vetRepository;

    public function __construct(PetReadingRepositoryInterface $petReadingRepository, PetRepositoryInterface $petRepository, VetRepositoryInterface $vetRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->petReadingRepository = $petReadingRepository;
        $this->petRepository = $petRepository;
        $this->vetRepository = $vetRepository;
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

        return response()->json(['error' => false, 'result' => $reading], 201);

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
        $this->petRepository->setUser($this->authUser);
        $data['microchip_number'] = $this->petRepository->get($pet_id)->microchip_number;

        //If current user is the owner of the microchip and the pet then update
        if ($this->petRepository->checkOwner($pet_id)
            && $this->petRepository->checkOwner($newPetId)
            && $this->petRepository->update($newPetId, $data)
        ) {
            // reassign readings
            $this->petReadingRepository->reassignReadings($pet_id, $newPetId);
            $this->petRepository->delete($pet_id);
            return response()->json(['error' => false, 'result' => Lang::get('general.Pet microchip number assigned')]);

        }

        return response()->json(['error' => true, 'result' => Lang::get('general.Problem assigning the microchip')]);

    }


    public function destroy($pet_id, $reading_id) {

        try {
            $this->petReadingRepository->setUser($this->authUser);
            $this->petReadingRepository->deleteReading($pet_id, $reading_id);

            return response()->json(['error' => false,
                'result' => Lang::get('general.Reading Deleted')]);

        }catch (\Exception $e){
            return response()->json(['error' => true,
                'result' => Lang::get('general.Reading delete fails: '.$e->getMessage())]);

        }

    }


}
