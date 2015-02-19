<?php namespace Repositories;

use Entities\Animal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnimalRepository extends AbstractRepository implements AnimalRepositoryInterface
{
    protected $classname = 'Entities\Animal';
    
    protected $repository;
    
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {             
        if($this->user)
        {
            return $this->user->animals()->get();
        }

        return parent::all();
    }
    
    public function get($id)
    {
        if($id)
        {
            return $this->user ? $this->user->animals()->findOrFail($id) : parent::get($id);
        }

    }
    
    public function create($input)
    {

            /**
            * @var \Entities\Device
            */
            $animal = parent::create($input);

            if($this->user)
            {
                // set access
                $animal->user()->associate($this->user);
                $animal->save();
            }        

        return $animal;
    }

    public function getCreateValidator($input)
    {
        return \Validator::make($input,
        [
            'name' => ['required'],
            'microchip_number' => ['required'],
            'breed' => ['required'],
            'date_of_birth' => ['required'],
            'gender' => ['required']
        ]);
    }


    public function getUpdateValidator($input)
    {
        return \Validator::make($input,
        [
            'name' => ['sometimes','required'],
            'microchip_number'    => ['sometimes','required'],
            'breed'     => ['sometimes','required'],
        ]);
    }
    
    public function setUser($user)
    {
        $this->user = is_numeric($user) ? $this->repository->get($user) : $user;

        return $this;
    }
}

?>
