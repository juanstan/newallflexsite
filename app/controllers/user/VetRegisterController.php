<?php namespace User;

use Entities\Vet;
use Entities\User;
use Repositories\VetRepositoryInterface;
use Repositories\UserRepositoryInterface;
use Repositories\AnimalRepositoryInterface;

class VetRegisterController extends \BaseController
{

    protected $authUser;
    protected $user;
    protected $vet;
    protected $repository;

    public function __construct(UserRepositoryInterface $user, AnimalRepositoryInterface $repository, VetRepositoryInterface $vet)
    {
        $this->authUser = \Auth::user()->get();
        $this->repository = $repository;
        $this->vet = $vet;
        $this->user = $user;
        $this->beforeFilter('csrf', array('on' => 'post'));
        $this->beforeFilter('auth', array('only' => array('getIndex', 'getAdd', 'postNew')));
    }

    public function getIndex()
    {
        return \View::make('usersignup.stage4');
    }


    public function getAdd()
    {
        $vets = $this->vet->all();
        return \View::make('usersignup.stage5')->with('vets', $vets);
    }

    public function postAdd($id) // PUT
    {
        $this->repository->setUser($this->authUser);
        $userid = \Auth::user()->get()->id;
        $pets = $this->repository->all();
        foreach ($pets as $pet) {
            \DB::table('animal_requests')->insert(
                ['vet_id' => $id, 'user_id' => $userid, 'animal_id' => $pet->id, 'approved' => 1]
            );
        }
        return \Redirect::route('user.register.vet')->with('success', 'Vet added');
    }

}
