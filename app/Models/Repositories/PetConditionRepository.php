<?php namespace App\Models\Repositories;

use App\Models\Entities\PetCondition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PetConditionRepository extends AbstractRepository implements PetConditionRepositoryInterface
{
    //protected $classname = 'App\Models\Entities\PetCondition';
    protected $model;
    protected $userRepo;
    protected $pet;
    
    public function __construct(PetCondition $model, UserRepositoryInterface $user)
    {
        $this->userRepo = $user;
        $this->model = $model;
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
    
    public function setPet($pet)
    {
        $this->pet = $pet;

        return $this;
    }

    public function removeAndUpdateConditions($petId, $conditions)
    {
        $this->query()->where('pet_id', '=', $petId)->delete();

        foreach ($conditions as $condition) {

            $petCondition = $this->query()->where(['pet_id' => $petId, 'condition_id' => $condition])->first();
            if (empty($petCondition)) {
                $petCondition = new PetCondition;
                $petCondition->condition_id = $condition;
                $petCondition->pet_id = $petId;
                $petCondition->save();
            }
        }

    }

   
}

?>
