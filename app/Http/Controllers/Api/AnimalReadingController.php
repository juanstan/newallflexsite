<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use Lang;
use URL;

use App\Models\Entities\Animal;
use App\Models\Entities\SensorReading;
use App\Models\Repositories\AnimalReadingRepositoryInterface;
use App\Models\Repositories\AnimalRepositoryInterface;
use App\Http\Controllers\Controller;

class AnimalReadingController extends Controller
{

    protected $authUser;
    protected $animalReadingRepository;
    protected $animalRepository;

    public function __construct(AnimalReadingRepositoryInterface $animalReadingRepository, AnimalRepositoryInterface $animalRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->animalReadingRepository = $animalReadingRepository;
        $this->animalRepository = $animalRepository;
    }

    public function index($animal_id)
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalReadingRepository->setAnimal($animal);

        return response()->json(['error' => false,
            'result' => $this->animalReadingRepository->all()]);

    }

    public function store($animal_id) // POST
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalReadingRepository->setAnimal($animal);



        $input = Input::all();
        $input['animal_id'] = $animal_id;


        $validator = $this->animalReadingRepository->getCreateValidator($input);


        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }



        $reading = $this->animalReadingRepository->create($input);



        if ($reading == null) {
            \App::abort(500);
        }

        return response()->json(['error' => false, 'result' => $reading], 201)
            ->header('Location', URL::route('api.animal.{animal_id}.reading.show', [$reading->id]));

    }

    public function show($animal_id, $id) // GET
    {
        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalReadingRepository->setAnimal($animal);

        return response()->json(['error' => false,
            'result' => $this->animalReadingRepository->get($id)]);
    }

    public function update($animal_id, $id) // PUT
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalReadingRepository->setAnimal($animal);

        $input = Input::all();

        $validator = $this->animalReadingRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->animalReadingRepository->update($id, $input) == false) {

            \App::abort(500);
        }

        return response()->json(['error' => false,
            'result' => $this->animalReadingRepository->get($id)]);
    }

    public function postAssign($animal_id)
    {
        $newPetId = Input::get('pet_id');
        $query = $this->animalRepository->get($animal_id);
        $data['microchip_number'] = $query->microchip_number;
        if ($this->animalRepository->update($newPetId, $data)) {
            $this->animalRepository->delete($animal_id);
            $sensorReading = $this->sensorReadingRepository->getByAnimalId($animal_id);
            $this->sensorReadingRepository->update($sensorReading->id, array('animal_id' => $newPetId));
        }
        return response()->json(['error' => false,
            'result' => Lang::get('general.Pet microchip number assigned')]);
    }


}
