<?php namespace App\Models\Repositories;

use App\Models\Entities\Pet;
use Validator;

class PetRepository extends AbstractRepository implements PetRepositoryInterface
{
    //protected $classname = 'App\Models\Entities\Pet';
    protected $model;
    protected $user;
    protected $userRepository;

    public function __construct(Pet $model, UserRepositoryInterface $user)
    {
        $this->userRepository = $user;
        $this->model = $model;
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
            'name' 			=> ['sometimes','required'],
            'date_of_birth' => ['sometimes','required','date'],
            'weight'     	=> ['sometimes','required'],
            'gender'		=> ['sometimes','required']
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
        $this->user = is_numeric($user) ? $this->userRepository->get($user) : $user;

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


    public function petsSet() {
        if($this->user) {
            return $this->user->pets()->whereNotNull('name')->get();
        }

    }

    public function microchipUnassigned() {
        if($this->user) {
            return $this->user->pets()->setMicrochip()->whereNull('name')->get();
        }
    }


}

?>
