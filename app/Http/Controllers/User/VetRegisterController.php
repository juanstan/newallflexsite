<?php namespace App\Http\Controllers\User;

use Auth;
use View;
use Lang;

use App\Models\Entities\Vet;
use App\Models\Entities\User;
use App\Models\Repositories\VetRepository;
use App\Models\Repositories\UserRepository;
use App\Models\Repositories\AnimalRepository;
use App\Models\Repositories\AnimalRequestRepository;
use App\Http\Controllers\Controller;

class VetRegisterController extends Controller
{

    protected $authUser;
    protected $userRepository;
    protected $vetRepository;
    protected $animalRepository;
    protected $animalRequestRepository;

    public function __construct(UserRepository $userRepository, AnimalRepository $animalRepository, VetRepository $vetRepository, AnimalRequestRepository $animalRequestRepository)
    {
        $this->authUser = Auth::user()->get();
        $this->animalRepository = $animalRepository;
        $this->vetRepository = $vetRepository;
        $this->userRepository = $userRepository;
        $this->animalRequestRepository = $animalRequestRepository;
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
        $this->animalRepository->setUser($user);
        $animals = $this->animalRepository->all();
        foreach ($animals as $animal) {
            if ($this->animalRequestRepository->getByVetAndAnimalId($vetId, $animal->id) == null)
            {
                $data = array(
                    'vet_id' => $vetId,
                    'user_id' => $user->id,
                    'animal_id' => $animal->id,
                    'approved' => 1
                );
                $this->animalRequestRepository->create($data);
            }
            else {
                continue;
            }
        }
        return redirect()->route('user.register.vet')
            ->with('success', Lang::get('general.Vet added'));
    }

}
