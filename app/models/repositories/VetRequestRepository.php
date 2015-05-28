<?php namespace Repositories;

class VetRequestRepository extends AbstractRepository implements VetRequestRepositoryInterface
{
    protected $classname = 'Entities\Animal\Request';
    
    protected $repository;
    
    public function __construct(VetRepositoryInterface $repository)
    {
        $this->repository = $repository;
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

        $userrequest = parent::create($input);

        $userrequest->request_type = 1;

        if($this->user)
        {
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
        ]);
    }

    public function getUpdateValidator($input)
    {
        return \Validator::make($input,
        [
            'vet_id' => ['required','exists:vets,id'],
            'animal_id' => ['required','exists:animals,id'],
        ]);
    }
    
    public function setUser($user)
    {
        $this->user = is_numeric($user) ? $this->repository->get($user) : $user;

        return $this;
    }
}

?>
