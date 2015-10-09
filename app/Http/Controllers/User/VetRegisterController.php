<?php namespace App\Http\Controllers\User;

use Auth;
use View;
use Lang;

use App\Models\Entities\Vet;
use App\Models\Entities\User;
use App\Models\Repositories\VetRepository;
use App\Models\Repositories\UserRepository;
use App\Models\Repositories\PetRepository;
use App\Models\Repositories\PetRequestRepository;
use App\Http\Controllers\Controller;

class VetRegisterController extends Controller
{

    protected $authUser;
    protected $userRepository;
    protected $vetRepository;
    protected $petRepository;
    protected $petRequestRepository;

    public function __construct(UserRepository $userRepository, PetRepository $petRepository, VetRepository $vetRepository, PetRequestRepository $petRequestRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->petRepository = $petRepository;
        $this->vetRepository = $vetRepository;
        $this->userRepository = $userRepository;
        $this->petRequestRepository = $petRequestRepository;
        $this->middleware('auth.user', array('only' => array('getIndex', 'getAdd', 'getAddVet')));
    }

    public function getIndex()
    {
        return View::make('usersignup.vetSetup');
    }


    public function getAdd()
    {
        $vets = $this->vetRepository->all();
        return View::make('usersignup.vetSelect')
            ->with(
                array(
                    'vets' => $vets
                ));
    }

    public function getAddVet($vetId)
    {
        $user = $this->authUser;
        $this->petRepository->setUser($user);
        $pets = $this->petRepository->all();
        foreach ($pets as $pet) {
            if ($this->petRequestRepository->getByVetAndPetId($vetId, $pet->id) == null)
            {
                $data = array(
                    'vet_id' => $vetId,
                    'user_id' => $user->id,
                    'pet_id' => $pet->id,
                    'approved' => 1
                );
                $this->petRequestRepository->create($data);
            }
            else {
                continue;
            }
        }
        return redirect()->route('user.register.vet')
            ->with('success', Lang::get('general.Vet added'));
    }

}
