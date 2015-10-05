<?php namespace App\Http\Controllers\Api;

use Auth;
use Input;
use URL;

use App\Models\Entities\User;
use App\Models\Entities\Animal;
use App\Models\Repositories\AnimalRepositoryInterface;
use App\Http\Controllers\Controller;

class AnimalController extends Controller
{

    protected $authUser;
    protected $animalRepository;

    public function __construct(AnimalRepositoryInterface $animalRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->animalRepository = $animalRepository;
    }

    public function index()
    {
        $this->animalRepository->setUser($this->authUser);

        return response()->json(['error' => false,
            'result' => $this->animalRepository->all()]);
    }

    public function store() // POST
    {
        $input = Input::all();
        $user = $this->authUser;
        $breed = $this->breedRepository->getBreedIdByName($input['breed_id']);

        $this->animalRepository->setUser($user);

        if($user->weight_units == "lbs") {
            $input['weight'] = $input['weight'] * 0.453592;
        }

        if($breed == NULL)
        {
            $input['breed_wildcard'] = $input['breed_id'];
        }
        else
        {
            $input['breed_id'] = $breed->id;
        }

        $validator = $this->animalRepository->getCreateValidator($input);

        if($validator->fails())
        {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (Input::hasFile('image_path')) {

            $imageValidator = $this->photoRepository->getCreateValidator($input);
            if($imageValidator->fails())
            {
                return redirect()->back()
                    ->withErrors($imageValidator)
                    ->withInput();
            }
            $photo = array(
                'title' => $user->id,
                'location' => $this->photoRepository->uploadImage($input['image_path'], $user)
            );
            $photoId = $this->photoRepository->createForUser($photo, $user);
            unset($input['image_path']);
            $input['photo_id'] = $photoId->id;

        }

        $animal = $this->animalRepository->create($input);

        if ($animal == null) {
            \App::abort(500);
        }

        return response()->json(['error' => false, 'result' => $animal], 201)
            ->header('Location', URL::route('api.animal.show', [$animal->id]));
    }

    public function show($id) // GET
    {
        $this->animalRepository->setUser($this->authUser);

        return response()->json(['error' => false,
            'result' => $this->animalRepository->get($id)]);
    }

    public function update($id) // PUT
    {
        $user = $this->authUser;
        $input = Input::all();
        $this->animalRepository->setUser($user);
        $breed = $this->breedRepository->getBreedIdByName($input['breed_id']);
        if($breed)
        {
            $input['breed_id'] = $breed->id;
        }
        else
        {
            $input['breed_wildcard'] = $input['breed_id'];
        }
        if($user->weight_units == "lbs") {
            $input['weight'] = round($input['weight'] * 0.453592, 1);
        }
        $validator = $this->animalRepository->getUpdateValidator($input);
        if ($validator->fails()) {
            return redirect()->route('user.dashboard')->withInput()
                ->withErrors($validator);
        }
        if ($this->animalRepository->update($id, $input) == false) {
            \App::abort(500);
        }
        $animal = $this->animalRepository->get($id);
        $userId = $user->id;
        if ($animal->vet_id != null) {
            Request::insert(
                ['vet_id' => $animal->vet_id, 'user_id' => $userId, 'animal_id' => $animal->id, 'approved' => 1]
            );
        }

        return response()->json(['error' => false,
            'result' => $this->animalRepository->get($id)]);
    }

    public function destroy($id) // DELETE
    {
        $this->animalRepository->setUser($this->authUser);

        $this->animalRepository->delete($id);
        return response()->json(['error' => false, 'result' => 'Item removed']);
    }

}
