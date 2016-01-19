<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use URL;

use App\Models\Entities\Pet;
use App\Models\Entities\Condition;
use App\Models\Repositories\ConditionRepositoryInterface;
use App\Models\Repositories\PetRepositoryInterface;
use App\Http\Controllers\Controller;

class PetConditionController extends Controller
{

    protected $authUser;
    protected $conditionRepository;
    protected $petRepository;

    public function __construct(PetRepositoryInterface $petRepository, ConditionRepositoryInterface $conditionRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->conditionRepository = $conditionRepository;
        $this->petRepository = $petRepository;
    }

    public function index($pet_id)
    {
        $this->petRepository->setUser($this->authUser);

        return response()->json(['error' => false,
            'result' => $this->petRepository->get($pet_id)->conditions()->get()]);

    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return Response
     */
    public function store($pet_id) // POST
    {
        $this->petRepository->setUser($this->authUser);
        $pet = $this->petRepository->get($pet_id);
        $input = Input::all();
        $validator = $this->conditionRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $condition = $pet->conditions()->attach($input['condition_id']);

        return response()->json(['error' => false, 'result' => $condition], 201)
            ->header('Location', URL::route('api.pet.{pet_id}.condition.show', [$condition->pet_id]));

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($pet_id, $id) // GET
    {
        $this->petRepository->setUser($this->authUser);
        $pet = $this->petRepository->get($pet_id);
        $this->petConditionRepository->setPet($pet);

        return response()->json(['error' => false,
            'result' => $this->petConditionRepository->get($id)]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($pet_id, $id) // PUT
    {

        $this->petRepository->setUser($this->authUser);
        $pet = $this->petRepository->get($pet_id);
        $input = Input::all();
        $validator = $this->conditionRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $pet->conditions()->updateExistingPivot($id, $input);

        return response()->json(['error' => false,
            'result' => $this->conditionRepository->get($input['condition_id'])]);
    }


    /**
     * Remove the specified condition from pet.
     *
     * @param  int $id      Condition ID
     * @param  int $pet_id  Pet ID
     *
     * @return Response
     */
    public function destroy($pet_id, $id) // DELETE
    {
        $this->petRepository->setUser($this->authUser);
        $pet = $this->petRepository->get($pet_id);
        $pet->conditions()->detach($id);

        return response()->json(['error' => false]);
    }






}
