<?php namespace App\Http\Controllers\Api;

use App\Models\Entities\Animal;
use App\Models\Entities\SensorReading;
use App\Models\Repositories\AnimalReadingRepositoryInterface;
use App\Models\Repositories\AnimalRepositoryInterface;

class AnimalReadingController extends \App\Http\Controllers\Controller
{

    protected $authUser;
    protected $animalReadingRepository;
    protected $animalRepository;

    public function __construct(AnimalReadingRepositoryInterface $animalReadingRepository, AnimalRepositoryInterface $animalRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->animalReadingRepository = $animalReadingRepository;
        $this->animalRepository = $animalRepository;
    }

    public function index($animal_id)
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalReadingRepository->setAnimal($animal);

        return \Response::json(['error' => false,
            'result' => $this->animalReadingRepository->all()]);

    }

    public function store($animal_id) // POST
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalReadingRepository->setAnimal($animal);



        $input = \Input::all();
        $input['animal_id'] = $animal_id;


        $validator = $this->animalReadingRepository->getCreateValidator($input);


        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }



        $reading = $this->animalReadingRepository->create($input);



        if ($reading == null) {
            \App::abort(500);
        }

        return \Response::json(['error' => false, 'result' => $reading], 201)
            ->header('Location', \URL::route('api.animal.{animal_id}.reading.show', [$reading->id]));

    }

    public function show($animal_id, $id) // GET
    {
        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalReadingRepository->setAnimal($animal);

        return \Response::json(['error' => false,
            'result' => $this->animalReadingRepository->get($id)]);
    }

    public function update($animal_id, $id) // PUT
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalReadingRepository->setAnimal($animal);

        $input = \Input::all();

        $validator = $this->animalReadingRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->animalReadingRepository->update($id, $input) == false) {

            \App::abort(500);
        }

        return \Response::json(['error' => false,
            'result' => $this->animalReadingRepository->get($id)]);
    }

    public function postAssign($animal_id)
    {
        $input = \Input::get('pet_id');
        $query = Animal::where('id', '=', $animal_id)->first();
        if (Animal::where('id', $input)->update(array('microchip_number' => $query->microchip_number))) {
            Animal::where('id', '=', $animal_id)->delete();
            SensorReading::where('animal_id', '=', $animal_id)->update(array('animal_id' => $input));
        }
        return \Response::json(['error' => false,
            'result' => \Lang::get('general.Pet microchip number assigned')]);
    }


}
