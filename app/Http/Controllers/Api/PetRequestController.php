<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use URL;

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

    public function index()
    {
        $this->petRequestRepository->setUser($this->authUser);

        return response()->json(['error' => false,
            'result' => $this->petRequestRepository->all()]);
    }

    public function store() // POST
    {
        $this->petRequestRepository->setUser($this->authUser);

        $input = Input::all();
        $validator = $this->petRequestRepository->getCreateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        $petRequest = $this->petRequestRepository->create($input);

        if ($petRequest == null) {
            \App::abort(500);
        }

        return response()->json(['error' => false, 'result' => $petRequest], 201)
            ->header('Location', URL::route('api.pet.show', [$petRequest->id]));
    }

    public function update($id) // PUT
    {
        $this->petRequestRepository->setUser($this->authUser);

        $input = Input::all();
        $validator = $this->petRequestRepository->getUpdateValidator($input);

        if ($validator->fails()) {
            return response()->json(['error' => true,
                'errors' => $validator->messages()], 400);
        }

        if ($this->petRequestRepository->update($id, $input) == false) {
            \App::abort(500);
        }

        return response()->json(['error' => false,
            'result' => $this->petRequestRepository->get($id)]);
    }

    public function show($id) // GET
    {
        $this->petRequestRepository->setUser($this->authUser);

        return response()->json(['error' => false,
            'result' => $this->petRequestRepository->get($id)]);
    }

    public function destroy($id) // DELETE
    {
        $this->petRequestRepository->setUser($this->authUser);

        $this->petRequestRepository->delete($id);
        return response()->json(['error' => false, 'result' => 'Request #' . $id . ' deleted']);
    }



}