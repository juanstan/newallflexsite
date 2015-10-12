<?php namespace App\Http\Controllers\Vet;

use App\Models\Entities\Vet;
use App\Models\Repositories\VetRepositoryInterface;
use App\Models\Repositories\UserRepositoryInterface;

class VetRegisterController extends \App\Http\Controllers\Controller {
    
    protected $authVet;
	protected $vetRepository;

	public function __construct(VetRepositoryInterface $vetRepository)
	{
		$this->authVet = \Auth::vet()->get();
        $this->vetRepository = $vetRepository;
        $this->middleware('auth.vet', array('only'=>array('getIndex', 'getAdd')));
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

}
