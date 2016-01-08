<?php namespace App\Models\Repositories;

use App\Models\Entities\PetCondition;
use App\Models\Entities\Condition;
use App\Models\Entities\SensorReadingSymptom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SensorReadingSymptomRepository extends AbstractRepository implements SensorReadingSymptomRepositoryInterface
{
    //protected $classname = 'App\Models\Entities\SensorReadingSymptom';
    protected $model;
    protected $userRepo;
    protected $pet;
    
    public function __construct(SensorReadingSymptom $model, UserRepositoryInterface $user)
    {
        $this->model = $model;
        $this->userRep = $user;
    }

    public function getCreateValidator($input)
    {
        return \Validator::make($input,
        [
            'symptom_id' => ['required','exists:conditions,id'],
        ]);
    }


    public function getUpdateValidator($input)
    {
        return \Validator::make($input,
        [
            'symptom_id' => ['required'],
        ]);
    }

    public function removeAndUpdateSymptoms($readingId, $symptoms)
    {
        $this->query()->where('reading_id', '=', $readingId)->delete();

        foreach ($symptoms as $symptom) {

            $readingSymptom = $this->query()->where(['reading_id' => $readingId, 'symptom_id' => $symptom])->first();
            if (empty($readingSymptom)) {
                $readingSymptom = new SensorReadingSymptom;
                $readingSymptom->symptom_id = $symptom;
                $readingSymptom->reading_id = $readingId;
                $readingSymptom->save();
            }
        }
    }

    public function removeSymptomById($readingId, $symptomId)
    {
        return $this->query()->where(['reading_id'=> $readingId, 'symptom_id' => $symptomId])->delete();
    }
   
}

?>
