<?php namespace App\Http\Controllers\User;

use App\Models\Entities\Vet;
use App\Models\Entities\Animal\Request;
use App\Models\Entities\User;
use App\Models\Repositories\VetRepositoryInterface;
use App\Models\Repositories\UserRepositoryInterface;
use App\Models\Repositories\AnimalRepositoryInterface;

class VetRegisterController extends \App\Http\Controllers\Controller
{

    protected $authUser;
    protected $userRepository;
    protected $vetRepository;
    protected $animalRepository;

    public function __construct(UserRepositoryInterface $userRepository, AnimalRepositoryInterface $animalRepository, VetRepositoryInterface $vetRepository)
    {
        $this->authUser = \Auth::user()->get();
        $this->animalRepository = $animalRepository;
        $this->vetRepository = $vetRepository;
        $this->userRepository = $userRepository;
        $this->middleware('auth.user', array('only' => array('getIndex', 'getAdd', 'getAddVet')));
    }

    public function getIndex()
    {
        return \View::make('usersignup.stage4');
    }


    public function getAdd()
    {
        $vets = $this->vetRepository->all();
        return \View::make('usersignup.stage5')->with('vets', $vets);
    }

    public function getAddVet($id) // PUT
    {
        $this->animalRepository->setUser($this->authUser);
        $userid = $this->authUser->id;
        $animals = $this->animalRepository->all();
        foreach ($animals as $animal) {
            if (Request::where('vet_id', $id)->where('animal_id', $animal->id)->first() == null) {
                Request::insert(
                    ['vet_id' => $id, 'user_id' => $userid, 'animal_id' => $animal->id, 'approved' => 1]
                );
            }
            else {
                continue;
            }
        }
        return \Redirect::route('user.register.vet')->with('success', \Lang::get('general.Vet added'));
    }

}
