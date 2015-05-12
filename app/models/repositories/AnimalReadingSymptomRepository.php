<?php namespace Repositories;

use Entities\SensorReading;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnimalReadingSymptomRepository extends AbstractRepository implements AnimalReadingSymptomRepositoryInterface
{
    protected $classname = 'Entities\SensorReadingSymptom';
    
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
            return $this->sensorReadings->symptom ? $this->sensorReadings->symptom()->findOrFail($id) : parent::get($id);
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
            'symptom_id' => ['required','integer','exists:symptoms,id']
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
   
}

?>
