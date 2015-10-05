<?php namespace App\Models\Repositories;

use App\Models\Entities\AnimalCondition;
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

    public function removeAndUpdateConditions($animalId, $conditions)
    {
        $this->query()->where('animal_id', '=', $animalId)->delete();

        foreach ($conditions as $condition) {

            $animalCondition = $this->query()->where(['animal_id' => $animalId, 'condition_id' => $condition])->first();
            if (empty($animalCondition)) {
                $animalCondition = new AnimalCondition;
                $animalCondition->condition_id = $condition;
                $animalCondition->animal_id = $animalId;
                $animalCondition->save();
            }
        }

    }
   
}

?>
