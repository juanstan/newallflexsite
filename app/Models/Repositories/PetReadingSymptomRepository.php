<?php namespace App\Models\Repositories;

use App\Models\Entities\SensorReading;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PetReadingSymptomRepository extends AbstractRepository implements PetReadingSymptomRepositoryInterface
{
    protected $classname = 'App\Models\Entities\SensorReadingSymptom';
    
    protected $repository;
        
    protected $sensorReadings;
    
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function all()
    {             
        if($this->sensorReadings)
        {
            return $this->sensorReadings->sensorReadingSymptoms()->get();
        }

        return parent::all();
    }
    
    public function get($id)
    {
        if($id)
        {
            return $this->sensorReadings->sensorReadingSymptoms ? $this->sensorReadings->sensorReadingSymptoms()->findOrFail($id) : parent::get($id);
        }

    }
    
    public function create($input)
    {

            /**
            * @var \Entities\Device
            */
            $symptom = parent::create($input);
            
            $symptom->sensorReading()->associate($this->sensorReadings);
            
            $symptom->save();
                 

        return $symptom;
    }

    public function getCreateValidator($input)
    {
        return \Validator::make($input,
        [
            'symptom_id' => ['required','integer','exists:symptoms,id','unique:sensor_reading_symptoms,symptom_id,NULL,id,reading_id,'.$input['reading_id']]
        ]);
    }


    public function getUpdateValidator($input)
    {
        return \Validator::make($input,
        [
            'symptom_id' => ['sometimes','required','integer','exists:symptoms,id'],
        ]);
    }
    
    public function setReading($reading)
    {
        $this->sensorReadings = $reading;

        return $this;
    }

    public function deleteBySymptomIdForReading($reading, $symptomId)
    {
        $readingSymptoms = $this->sensorReadings->sensorReadingSymptoms()->where('symptom_id', '=', $symptomId)->get();

    foreach($readingSymptoms as $readingSymptom)
    {
        $readingSymptom->delete();
    }
}
   
}

?>