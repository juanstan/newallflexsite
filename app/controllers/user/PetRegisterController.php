<?php namespace User;

use Entities\Animal;
use Entities\Breed;
use Repositories\AnimalRepositoryInterface;

class PetRegisterController extends \BaseController
{

    protected $authUser;
    protected $animalRepository;

    public function __construct(AnimalRepositoryInterface $animalRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->animalRepository = $animalRepository;
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getIndex', 'getNew', 'postNew')));
    }

    public function getIndex()
    {
        $this->animalRepository->setUser($this->authUser);
        $pets = $this->animalRepository->all();
        return \View::make('usersignup.stage3')->with('pets', $pets);

    }

    public function getBreeds()
    {
        $breeds = Breed::all()->lists('name', 'id');
        $term = \Input::get('term');
        $result = [];
        foreach($breeds as $breed) {
            if(strpos($breed,$term) !== false) {
                $result[] = ['value' => $breed];
            }
        }
        return \Response::json($result);
    }

    public function getCreate()
    {
        $breed = Breed::all()->lists('name', 'id');
        return \View::make('usersignup.stage2')->with('breed', $breed);
    }

    public function postCreate() // POST
    {

        $this->animalRepository->setUser($this->authUser);

        if($this->authUser->weight_units == "LBS") {

            $weight = round(\Input::get('weight') * 0.453592, 1);
            \Input::merge(array('weight' => $weight));

        }

        if(Breed::where('name', '=', \Input::get('breed_id'))->first())
        {
            $breed_id = Breed::where('name', '=', \Input::get('breed_id'))->first();
            \Input::merge(array('breed_id' => $breed_id->id));
        }
        else
        {
            $breed_wildcard = \Input::get('breed_id');
            \Input::merge(array('breed_wildcard' => $breed_wildcard));
        }

        $input = \Input::all();
        $validator = $this->animalRepository->getCreateValidator($input);

        if($validator->fails())
        {
            return \Redirect::route('user.register.pet.create')
                ->withErrors($validator);
        }

        $id = $this->authUser->id;

        if (\Input::hasFile('pet-photo')) {

            $destinationPath = 'uploads/pets/' . $id;
            if (!\File::exists($destinationPath)) {
                \File::makeDirectory($destinationPath);
            }


            $extension = \Input::file('pet-photo')->getClientOriginalExtension();
            $fileName = rand(11111, 99999) . '.' . $extension;

            $height = \Image::make(\Input::file('pet-photo'))->height();
            $width = \Image::make(\Input::file('pet-photo'))->width();

            if ($width > $height) {
                \Image::make(\Input::file('pet-photo'))->crop($height, $height)->save($destinationPath . '/' . $fileName);
            } else {
                \Image::make(\Input::file('pet-photo'))->crop($width, $width)->save($destinationPath . '/' . $fileName);
            }

            $input['image_path'] = '/uploads/pets/' . $id . '/' . $fileName;

        }

        $animal = $this->animalRepository->create($input);

        if ($animal == null) {
            \App::abort(500);
        }

        return \Redirect::route('user.register.pet');

    }


}
