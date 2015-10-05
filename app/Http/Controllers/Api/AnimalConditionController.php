<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use URL;

use App\Models\Entities\AnimalCondition;
use App\Models\Repositories\AnimalConditionRepositoryInterface;
use App\Models\Repositories\AnimalRepositoryInterface;
use App\Http\Controllers\Controller;

class AnimalConditionController extends Controller
{

    protected $authUser;
    protected $animalConditionRepository;
    protected $animalRepository;

    public function __construct(AnimalConditionRepositoryInterface $animalConditionRepository, AnimalRepositoryInterface $animalRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->animalConditionRepository = $animalConditionRepository;
        $this->animalRepository = $animalRepository;
    }

    public function index($animal_id)
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalConditionRepository->setAnimal($animal);

        return response()->json(['error' => false,
            'result' => $this->animalConditionRepository->all()]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($animal_id) // POST
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalConditionRepository->setAnimal($animal);

        $input = Input::all();
        $input['animal_id'] = $animal_id;
        $validator = $this->animalConditionRepository->getCreateValidator($input);


        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $reading = $this->animalConditionRepository->create($input);

        if ($reading == null) {
            \App::abort(500);
        }

        return response()->json(['error' => false, 'result' => $reading], 201)
            ->header('Location', URL::route('api.animal.{animal_id}.condition.show', [$reading->id]));

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($animal_id, $id) // GET
    {
        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalConditionRepository->setAnimal($animal);

        return response()->json(['error' => false,
            'result' => $this->animalConditionRepository->get($id)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($animal_id, $id) // PUT
    {

        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalConditionRepository->setAnimal($animal);

        $input = Input::all();
        $validator = $this->animalConditionRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->animalConditionRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return response()->json(['error' => false,
            'result' => $this->animalConditionRepository->get($id)]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($animal_id, $id) // DELETE
    {
        $this->animalRepository->setUser($this->authUser);

        $animal = $this->animalRepository->get($animal_id);

        $this->animalConditionRepository->setAnimal($animal);

        AnimalCondition::where('condition_id', '=', $id)->delete();

        return response()->json(['error' => false]);
    }


}
