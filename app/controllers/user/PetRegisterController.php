<?php namespace User;

use Entities\Animal;
use Entities\Breed;
use Repositories\AnimalRepositoryInterface;
use Repositories\UserRepositoryInterface;

class PetRegisterController extends \BaseController
{

    protected $authUser;

    protected $repository;

    public function __construct(AnimalRepositoryInterface $repository)
    {
        $this->authUser = \Auth::user()->get();
        $this->repository = $repository;
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getIndex', 'getNew', 'postNew')));
    }

    public function getIndex()
    {
        $this->repository->setUser($this->authUser);
        $pets = $this->repository->all();
        return \View::make('usersignup.stage3')->with('pets', $pets);

    }

    public function getBreeds()
    {
        $breeds = Breed::all()->lists('name', 'id');
        $term = \Input::get('term');
        $result = [];
        foreach($breeds as $breed) {
            if(strpos(\Str::lower($breed),$term) !== false) {
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

        $this->repository->setUser($this->authUser);

        if(\Auth::user()->get()->weight_units == "LBS") {

            $weight = round(\Input::get('weight') * 0.453592, 1);
            \Input::merge(array('weight' => $weight));

        }

        $breed_id = Breed::where('name', '=', \Input::get('breed_id'))->first();
        \Input::merge(array('breed_id' => $breed_id->id));

        $input = \Input::all();
        $validator = $this->repository->getCreateValidator($input);

        if($validator->fails())
        {
            return \Redirect::to('pet/register/pet/create')
                ->withErrors($validator);
        }

        $id = \Auth::user()->get()->id;

        if (\Input::hasFile('pet-photo')) {

//            $file = array('image' => \Input::file('pet-photo'));
//            $rules = array('image' => 'mimes:jpeg,png');
//            $validator = \Validator::make($file, $rules);
//            if ($validator->fails()) {
//                return \Redirect::route('user.register.pet.create')->withInput()
//                    ->withErrors($validator);
//            }
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

        $animal = $this->repository->create($input);

        if ($animal == null) {
            \App::abort(500);
        }

        return \Redirect::route('user.register.pet');

    }


}
