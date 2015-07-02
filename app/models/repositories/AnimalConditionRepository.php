<?php namespace App\Models\Repositories;

use App\Models\Entities\AnimalCondition;
use App\Models\Entities\Condition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnimalConditionRepository extends AbstractRepository implements AnimalConditionRepositoryInterface
{
    protected $classname = 'App\Models\Entities\AnimalCondition';
    
    protected $repository;
    
    protected $animal;
    
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {             
        if($this->animal)
        {
            return $this->animal->animalConditions()->get();
        }

        return parent::all();
    }
    
    public function get($id)
    {
        if($id)
        {
            return $this->animal ? $this->animal->animalConditions()->findOrFail($id) : parent::get($id);
        }

    }
    
    public function create($input)
    {

            /**
            * @var \Entities\Device
            */
            $reading = parent::create($input);
            
            $reading->animal()->associate($this->animal); 
            
            $reading->save();
                 

        return $reading;
    }

    public function getCreateValidator($input)
    {
        return \Validator::make($input,
        [
            'condition_id' => ['required','exists:conditions,id'],
        ]);
    }


    public function getUpdateValidator($input)
    {
        return \Validator::make($input,
        [
            'condition_id' => ['required'],
        ]);
    }
    
    public function setAnimal($animal)
    {
        $this->animal = $animal;

        return $this;
    }
   
}

?>
