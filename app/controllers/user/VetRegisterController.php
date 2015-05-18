<?php namespace User;

use Entities\Vet;
use Entities\User;
use Repositories\VetRepositoryInterface;
use Repositories\UserRepositoryInterface;
use Repositories\AnimalRepositoryInterface;

class VetRegisterController extends \BaseController
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
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getIndex', 'getAdd', 'postNew')));
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

    public function postAdd($id) // PUT
    {
        $this->animalRepository->setUser($this->authUser);
        $userid = $this->authUser->id;
        $pets = $this->animalRepository->all();
        foreach ($pets as $pet) {
            \DB::table('animal_requests')->insert(
                ['vet_id' => $id, 'user_id' => $userid, 'animal_id' => $pet->id, 'approved' => 1]
            );
        }
        return \Redirect::route('user.register.vet')->with('success', 'Vet added');
    }

}
