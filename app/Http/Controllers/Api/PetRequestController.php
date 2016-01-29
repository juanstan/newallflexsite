<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use URL;
use Carbon\Carbon;

use App\Models\Entities\User;
use App\Models\Entities\Pet;
use App\Models\Repositories\PetRepository;
use App\Models\Repositories\PetRequestRepository;
use App\Http\Controllers\Controller;

class PetRequestController extends Controller
{

    protected $authUser;
    protected $petRepository;
    protected $petRequestRepository;

    public function __construct(PetRequestRepository $petRequestRepository, PetRepository $petRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->petRepository = $petRepository;
        $this->petRequestRepository = $petRequestRepository;
    }

    public function index($pet_id)
    {
        $this->petRequestRepository->setUser($this->authUser);

        return response()->json(['error' => false,
            'result' => $this->petRequestRepository->getAllVetsByPet($pet_id)]);
    }

    public function store($pet_id) // POST
    {
        $this->petRepository->setUser($this->authUser);
        $input = Input::only('vet_id', 'approved');
        $validator = $this->petRequestRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $pet = $this->petRepository->get($pet_id);
        $pet->vet()->attach($input['vet_id'], $input);

        return response()->json(['error' => false, 'result' => ['vet_id'=>$input['vet_id'], 'pet_id'=>$pet->id]]);

    }

    public function update($pet_id, $vet_id) // PUT
    {
        $this->petRequestRepository->setUser($this->authUser);
        $input = Input::only('approved');

        $validator = $this->petRequestRepository->getUpdateValidator($input);
        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->petRequestRepository->updateState(['vet_id'=>$vet_id, 'pet_id'=>$pet_id], $input) == false) {
            \App::abort(500);
        }

        return response()->json(['error' => false, 'result' => array('pet_id'=>$pet_id, 'vet_id'=>$vet_id)]);
    }

    public function show($id) // GET
    {
        $this->petRequestRepository->setUser($this->authUser);

        return response()->json(['error' => false,
            'result' => $this->petRequestRepository->get($id)]);
    }

    public function destroy($pet_id, $vet_id) // DELETE
    {
        $this->petRequestRepository->setUser($this->authUser);
        $this->petRequestRepository->updateState(['pet_id'=>$pet_id, 'vet_id'=>$vet_id], ['deleted_at'=>Carbon::now()]);

        return response()->json(['error' => false]);
    }



}
