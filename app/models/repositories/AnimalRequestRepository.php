<?php namespace Repositories;

use Entities\Animal\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnimalRequestRepository extends AbstractRepository implements AnimalRequestRepositoryInterface
{
    protected $classname = 'Entities\Animal\Request';
    
    protected $repository;
    
    public function __construct(VetRepositoryInterface $vetRepositoryInterface, UserRepositoryInterface $userRepositoryInterface)
    {
        $this->user = $userRepositoryInterface;
        $this->vet = $vetRepositoryInterface;
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

    public function getCreateValidator($input)
    {
        return \Validator::make($input,
        [
            'animal_id' => ['required','exists:animals,id'],
            'vet_id' => ['required','exists:vets,id'],
        ]);
    }


    public function getUpdateValidator($input)
    {
        return \Validator::make($input,
        [
            'animal_id' => ['required','exists:animals,id'],
        ]);
    }
    
    public function setUser($user)
    {
        $this->user = is_numeric($user) ? $this->repository->get($user) : $user;

        return $this;
    }

    public function create($input)
    {

        $userRequest = parent::create($input);


        if($this->user)
        {
            // set access
            $userRequest->user()->associate($this->user);
            $userRequest->save();
        }

        return $userRequest;
    }
    
}

?>
