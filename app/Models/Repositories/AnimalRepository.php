<?php namespace App\Models\Repositories;

use App\Models\Entities\Animal;
use Validator;

class AnimalRepository extends AbstractRepository implements AnimalRepositoryInterface
{
    protected $classname = 'App\Models\Entities\Animal';
    
    protected $repository;
    
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->user = $userRepositoryInterface;
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
