<?php namespace App\Models\Repositories;

use App\Models\Entities\Animal;
use Validator;

class AnimalRepository extends AbstractRepository implements AnimalRepositoryInterface
{
    protected $classname = 'App\Models\Entities\Animal';
    
    protected $userRepositoryInterface;

    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->user = $userRepositoryInterface;

    }

    public function all()
    {
        dd('here');
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

        $animal = parent::create($input);

        if($this->user)
        {
            // set access
            $animal->user()->associate($this->user);
            $animal->save();
        }

        return $animal;
    }
}

?>
