<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use URL;
use Request;

use App\Models\Entities\User;
use App\Models\Entities\Vet;
use App\Models\Entities\Pet;
use App\Models\Repositories\PetRepository;
use App\Models\Repositories\PetRequestRepository;
use App\Models\Repositories\BreedRepository;
use App\Models\Repositories\PhotoRepository;
use App\Http\Controllers\Controller;

class PetController extends Controller
{

    protected $authUser;
    protected $petRepository;
    protected $petRequestRepository;
    protected $breedRepository;
    protected $photoRepository;

    public function __construct(PetRepository $petRepository, PetRequestRepository $petRequestRepository, BreedRepository $breedRepository, PhotoRepository $photoRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->petRepository = $petRepository;
        $this->petRequestRepository = $petRequestRepository;
        $this->breedRepository = $breedRepository;
        $this->photoRepository = $photoRepository;
    }

    public function index()
    {
        $this->petRepository->setUser($this->authUser);

        return response()->json(['error' => false,
            'result' => $this->petRepository->all()]);
    }

    public function store() // POST
    {
        $input = Input::all();
        $user = $this->authUser;

        $this->petRepository->setUser($user);

        if($user->weight_units == 1) {
            $input['weight'] = isset($input['weight']) ? $input['weight'] * 0.453592 : null;
        }

        if(isset($input['breed_id']))
        {
            $breed = $this->breedRepository->getBreedIdByName($input['breed_id']);
            if($breed == NULL)
            {
                $input['breed_wildcard'] = $input['breed_id'];
            }
            else
            {
                $input['breed_id'] = $breed->id;
            }
        }


        $validator = $this->petRepository->getCreateValidator($input);

        if($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pet = $this->petRepository->create($input);

        if ($pet == null) {
            \App::abort(500);
        }

        return response()->json(['error' => false, 'result' => $pet], 201)
            ->header('Location', URL::route('api.pet.show', [$pet->id]));
    }

    public function show($id) // GET
    {
        $this->petRepository->setUser($this->authUser);

        return response()->json(['error' => false,
            'result' => $this->petRepository->get($id)]);
    }

    public function update($id) // PUT
    {
        $user = $this->authUser;
        $input = Input::all();
        $this->petRepository->setUser($user);

        if(isset($input['breed_id'])) {
            $breed = $this->breedRepository->getBreedIdByName($input['breed_id']);
            if ($breed) {
                $input['breed_id'] = $breed->id;
            } else {
                $input['breed_wildcard'] = $input['breed_id'];
            }
        }
        if($user->weight_units == 1) {
            $input['weight'] = round($input['weight'] * 0.453592, 1);
        }
        $validator = $this->petRepository->getUpdateValidator($input);
        if ($validator->fails()) {
            return redirect()->route('user.dashboard')->withInput()
                ->withErrors($validator);
        }
        if ($this->petRepository->update($id, $input) == false) {
            \App::abort(500);
        }
        $pet = $this->petRepository->get($id);
        $userId = $user->id;
        if ($pet->vet_id != null) {
            $data = array(
                'vet_id' => $pet->vet_id,
                'user_id' => $userId,
                'pet_id' => $pet->id,
                'approved' => 1
            );
            $this->petRequestRepository->create($data);
        }

        return response()->json(['error' => false,
            'result' => $this->petRepository->get($id)]);
    }

    public function postPhoto($pet_id)
    {
        $user = $this->authUser;
        $this->petRepository->setUser($user);
        $validator = $this->photoRepository->getCreateValidator(Input::all());

        if($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->authUser;
        $request = Request::all();

        $photo = array(
            'title' => $user->id,
            'location' => $this->photoRepository->uploadImage($request['image_path'], $user)
        );

        $photo = $this->photoRepository->createForUser($photo, $user);

        unset($request['image_path']);
        $request['photo_id'] = $photo->id;

        if ($this->petRepository->update($pet_id, $request) == false) {
            \App::abort(500);
        }

        return response()->json(['error' => false,
            'result' => $this->petRepository->get($pet_id)]);
    }

    public function destroy($id) // DELETE
    {
        $this->petRepository->setUser($this->authUser);

        $this->petRepository->delete($id);
        return response()->json(['error' => false, 'result' => 'Item removed']);
    }

}
