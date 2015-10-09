<?php namespace App\Models\Repositories;

use App\Models\Entities\Pet;
use Validator;

class PetRepository extends AbstractRepository implements PetRepositoryInterface
{
    protected $classname = 'App\Models\Entities\Pet';
    
    protected $userRepositoryInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->user = $userRepositoryInterface;

    }

    public function all()
    {
        if($this->user)
        {
            return $this->user->pets()->get();
        }

        return parent::all();
    }

    public function get($id)
    {
        if($id)
        {
            return $this->user ? $this->user->pets()->findOrFail($id) : parent::get($id);
        }

    }

    public function getCreateValidator($input)
    {
        return Validator::make($input,
        [

        ]);
    }

    public function getUpdateValidator($input)
    {
        return Validator::make($input,
        [

        ]);
    }

    public function setUser($user)
    {
        $this->user = is_numeric($user) ? $this->repository->get($user) : $user;

        return $this;
    }

    public function create($input)
    {

        $pet = parent::create($input);

        if($this->user)
        {
            // set access
            $pet->user()->associate($this->user);
            $pet->save();
        }

        return $pet;
    }
}

?>
