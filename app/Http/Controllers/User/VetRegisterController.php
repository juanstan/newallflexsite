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
        $user = $this->authUser;
        $this->petRepository->setUser($user);
        $pets = $this->petRepository->all()->lists('id')->toArray();
        $aPetRequestLits = $this->petRequestRepository->getVetsByPets($pets)->toArray();

        $aVets = [];
        foreach($aPetRequestLits as $iPetRequestInfo) {
            $aVets[] = $this->vetRepository->getVetDetails($iPetRequestInfo['vet_id']);

        }

        return View::make('usersignup.vetSetup', array('vets'=>$aVets));
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
        $this->petRepository->setUser($this->authUser);
        $this->petRepository->attachDetachVet($vetId);

        return redirect()->route('user.register.vet')
            ->with('success', Lang::get('general.Vet added'));
    }

}
