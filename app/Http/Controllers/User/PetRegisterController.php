<?php namespace App\Http\Controllers\User;

use Auth;
use View;
use Input;
use Redirect;
use Image;
use File;
use Request;
use Illuminate\Validation\Validator;

use App\Models\Entities\Pet;
use App\Models\Repositories\PetRepository;
use App\Models\Repositories\PhotoRepository;
use App\Models\Repositories\BreedRepository;
use App\Http\Controllers\Controller;

class PetRegisterController extends Controller
{

    protected $authUser;
    protected $petRepository;
    protected $photoRepository;
    protected $breedRepository;

    public function __construct(PetRepository $petRepository, PhotoRepository $photoRepository, BreedRepository $breedRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->petRepository = $petRepository;
        $this->photoRepository = $photoRepository;
        $this->breedRepository = $breedRepository;
        $this->middleware('auth.user', array('only' => array('getIndex', 'getNew', 'postNew')));
    }

    public function getIndex()
    {
        $this->petRepository->setUser($this->authUser);
        $pets = $this->petRepository->petsSet();
        return View::make('usersignup.petList')
            ->with(array(
                'pets' => $pets
            ));

    }

    public function getBreeds()
    {
        $breeds = $this->breedRepository->all();
        $breeds = $breeds->lists('name', 'id');
        $term = Input::get('term');
        $result = [];
        foreach($breeds as $breed) {
            if(strpos($breed,$term) !== false) {
                $result[] = ['value' => $breed];
            }
        }
        return response()->json($result);
    }

    public function getCreate()
    {
        $user = $this->authUser;
        $breeds = $this->breedRepository->all();
        $breed = $breeds->lists('name', 'id');
        return View::make('usersignup.petCreate')->with(array('breed' => $breed,'user' => $user, 'pet'=>new Pet));
    }


    public function getEdit($pet_id) {
        $user = $this->authUser;
        $this->petRepository->setUser($user);
        $pet = $this->petRepository->get($pet_id);

        $breeds = $this->breedRepository->all();
        $breed = $breeds->lists('name', 'id');
        return View::make('usersignup.petEdit')->with(array('breed' => $breed,'user' => $user, 'pet'=>$pet));

    }


    public function postCreate()
    {
        $result = $this->settingValuesForPet();

        if (($result instanceof Validator)) {
            return redirect()->to(Request::path())
                ->withErrors($result)
                ->withInput();
        }

        $pet = $this->petRepository->create($result);

        if ($pet == null) {
            \App::abort(500);
        }

        return redirect()->route('user.register.pet');

    }



    public function postEdit($pet_id)
    {
        $result = $this->settingValuesForPet();
        if (($result instanceof Validator)) {
            return redirect()->to(Request::path())
                ->withErrors($result)
                ->withInput();
        }


        $pet = $this->petRepository->update($pet_id, $result);

        if ($pet == null) {
            \App::abort(500);
        }

        return redirect()->route('user.register.pet');

    }


    /*
     * Setting the params when creating or updating a pet
     *
     * @param $input array Values comming from the form
     * @param $user User user details
     *
     * @return array new input values
     *
     */
    private function settingValuesForPet() {

        $input = Input::all();
        $user = $this->authUser;

        $breed = $this->breedRepository->getBreedIdByName($input['breed_id']);
        $this->petRepository->setUser($user);

        if (($user->weight_units == 1 && $input['weight'])) {
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

        $validator = $this->petRepository->getCreateValidator($input);

        if($validator->fails())
        {
            return $validator;
        }

        if (Input::hasFile('image_path')) {
            $imageValidator = $this->photoRepository->getCreateValidator($input);
            if($imageValidator->fails())
            {

                return $imageValidator;

            }
            $photo = array(
                'title' => $user->id,
                'location' => $this->photoRepository->uploadImage($input['image_path'], $user)
            );
            $photoId = $this->photoRepository->createForUser($photo, $user);
            unset($input['image_path']);
            $input['photo_id'] = $photoId->id;

        }

        return $input;

    }



}
