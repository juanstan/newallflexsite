<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use URL;

use App\Models\Entities\PetCondition;
use App\Models\Repositories\PetConditionRepositoryInterface;
use App\Models\Repositories\PetRepositoryInterface;
use App\Http\Controllers\Controller;

class PetConditionController extends Controller
{

    protected $authUser;
    protected $petConditionRepository;
    protected $petRepository;

    public function __construct(PetConditionRepositoryInterface $petConditionRepository, PetRepositoryInterface $petRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->petConditionRepository = $petConditionRepository;
        $this->petRepository = $petRepository;
    }

    public function index($pet_id)
    {

        $this->petRepository->setUser($this->authUser);

        $pet = $this->petRepository->get($pet_id);

        $this->petConditionRepository->setPet($pet);

        return response()->json(['error' => false,
            'result' => $this->petConditionRepository->all()]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store($pet_id) // POST
    {

        $this->petRepository->setUser($this->authUser);

        $pet = $this->petRepository->get($pet_id);

        $this->petConditionRepository->setPet($pet);

        $input = Input::all();
        $input['pet_id'] = $pet_id;
        $validator = $this->petConditionRepository->getCreateValidator($input);


        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $reading = $this->petConditionRepository->create($input);

        if ($reading == null) {
            \App::abort(500);
        }

        return response()->json(['error' => false, 'result' => $reading], 201)
            ->header('Location', URL::route('api.pet.{pet_id}.condition.show', [$reading->id]));

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

        $this->petConditionRepository->setPet($pet);

        $input = Input::all();
        $validator = $this->petConditionRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->petConditionRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return response()->json(['error' => false,
            'result' => $this->petConditionRepository->get($id)]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($pet_id, $id) // DELETE
    {
        $this->petRepository->setUser($this->authUser);

        $pet = $this->petRepository->get($pet_id);

        $this->petConditionRepository->setPet($pet);

        PetCondition::where('condition_id', '=', $id)->delete();

        return response()->json(['error' => false]);
    }


}
