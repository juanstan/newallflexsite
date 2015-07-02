<?php namespace App\Http\Controllers\Api;

use App\Models\Entities\SensorReading;
use App\Models\Repositories\AnimalReadingSymptomRepositoryInterface;
use App\Models\Repositories\AnimalRepositoryInterface;
use App\Models\Repositories\AnimalReadingRepositoryInterface;

class AnimalReadingSymptomController extends \App\Http\Controllers\Controller
{

    protected $authUser;

    protected $animalReadingRepository;

    protected $animalRepository;

    protected $animalReadingSymptomRepository;

    public function __construct(AnimalReadingRepositoryInterface $animalReadingRepository, AnimalRepositoryInterface $animalRepository, AnimalReadingSymptomRepositoryInterface $animalReadingSymptomRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->animalReadingSymptomRepository = $animalReadingSymptomRepository;
        $this->animalRepository = $animalRepository;
        $this->animalReadingRepository = $animalReadingRepository;
    }

    public function index($animal_id, $reading_id)
    {

        $this->animalRepository->setUser($this->authUser);
        $animal = $this->animalRepository->get($animal_id);
        $this->animalReadingRepository->setAnimal($animal);
        $reading = $this->animalReadingRepository->get($reading_id);
        $this->animalReadingSymptomRepository->setReading($reading);

        return \Response::json(['error' => false,
            'result' => $this->animalReadingSymptomRepository->all()]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($animal_id, $reading_id) // POST
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalReadingRepository->setAnimal($animal);

        $reading = $this->animalReadingRepository->get($reading_id);

        $this->animalReadingSymptomRepository->setReading($reading);

        $input = \Input::all();
        $input['reading_id'] = $reading_id;
        $validator = $this->animalReadingSymptomRepository->getCreateValidator($input);


        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }


        $reading = $this->animalReadingSymptomRepository->create($input);

        if ($reading == null) {
            \App::abort(500);
        }

        return \Response::json(['error' => false, 'result' => $reading], 201)
            ->header('Location', \URL::route('api.animal.{animal_id}.reading.{reading_id}.symptom.show', [$reading->id]));

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($animal_id, $reading_id, $id) // GET
    {
        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalReadingRepository->setAnimal($animal);

        $reading = $this->animalReadingRepository->get($reading_id);

        $this->animalReadingSymptomRepository->setReading($reading);

        return \Response::json(['error' => false,
            'result' => $this->animalReadingSymptomRepository->get($id)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($animal_id, $reading_id, $id) // PUT
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalReadingRepository->setAnimal($animal);

        $reading = $this->animalReadingRepository->get($reading_id);

        $this->animalReadingSymptomRepository->setReading($reading);

        $input = \Input::all();

        $validator = $this->animalReadingSymptomRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return \Response::json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->animalReadingSymptomRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return \Response::json(['error' => false,
            'result' => $this->animalReadingSymptomRepository->get($id)]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($animal_id, $reading_id, $id) // DELETE
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalReadingRepository->setAnimal($animal);

        $reading = $this->animalReadingRepository->get($reading_id);

        $this->animalReadingSymptomRepository->setReading($reading);

        $this->animalReadingSymptomRepository->deleteBySymptomIdForReading($reading_id, $id);
        return \Response::json(['error' => false]);
    }


}
