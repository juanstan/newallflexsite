<?php namespace Repositories;

use Entities\Animal\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnimalRequestRepository extends AbstractRepository implements AnimalRequestRepositoryInterface
{
    protected $classname = 'Entities\Animal\Request';
    
    protected $repository;
    
    public function __construct(VetRepositoryInterface $vrepository, UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->vrepository = $vrepository;
    }

    public function all()
    {
        if($this->user)
        {
            return $this->user->requests()->get();
        }

        return parent::all();
    }
    
    public function get($id)
    {
        if($id)
        {
            return $this->user ? $this->user->requests()->findOrFail($id) : parent::get($id);
        }

    }
    
    public function create($input)
    {

            /**
            * @var \Entities\Device
            */
            
            
            $userrequest = parent::create($input);
            
            $userrequest->request_type = 0;

            if($this->user)
            {
                // set access
                $userrequest->user()->associate($this->user);
                $userrequest->save();
            }        

        return $userrequest;
    }

    public function getCreateValidator($input)
    {
        return \Validator::make($input,
        [
            'vet_id' => ['required','exists:vets,id'],
            'animal_id' => ['required','exists:animals,id'],
            'request_reason'     => ['required'],
        ]);
    }


    public function getUpdateValidator($input)
    {
        return \Validator::make($input,
        [
            'vet_id' => ['required','exists:vets,id'],
            'animal_id' => ['required','exists:animals,id'],
            'request_reason'     => ['required'],
        ]);
    }
    
    public function getApprovalValidator($input)
    {
        return \Validator::make($input,
        [
            'approved' => ['required'],
            'response_reason' => ['required'],
        ]);
    }
    
    public function setUser($user)
    {
        $this->user = is_numeric($user) ? $this->repository->get($user) : $user;

        return $this;
    }
    
}

?>
