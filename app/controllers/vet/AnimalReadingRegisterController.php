<?php  namespace Vet;

use Entities\Animal;
use Entities\Reading;
use Entities\Vet;
use League\Csv\Reader;
use Repositories\AnimalReadingRepositoryInterface;
use Repositories\AnimalRepositoryInterface;
use Repositories\VetRepositoryInterface;

class AnimalReadingRegisterController extends \BaseController {
    
    protected $authUser;
    protected $user;
    protected $repository;
    protected $arepository;

    public function __construct(VetRepositoryInterface $user,  AnimalReadingRepositoryInterface $repository, AnimalRepositoryInterface $arepository)
    {
        $this->authUser =  \Auth::user()->get();
        $this->user = $user;
        $this->repository = $repository;
        $this->arepository = $arepository;
        $this->beforeFilter('csrf', array('on'=>'post'));
        $this->beforeFilter('vetAuth', array('only'=>array('getIndex', 'postAssign', 'postFinish', 'getAssign', 'postAssign')));
    }
    
    public function getIndex()
    { 
        return \View::make('vetsignup.stage3');
    }


}
