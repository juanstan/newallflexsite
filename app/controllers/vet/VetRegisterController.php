<?php namespace Vet;

use Entities\Vet;
use Repositories\VetRepositoryInterface;
use Repositories\UserRepositoryInterface;

class VetRegisterController extends \BaseController {
    
    protected $authVet;
	protected $vetRepository;

	public function __construct(VetRepositoryInterface $vetRepository)
	{
		$this->authVet = \Auth::vet()->get();
        $this->vetRepository = $vetRepository;
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('vetAuth', array('only'=>array('getIndex', 'getAdd')));
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
