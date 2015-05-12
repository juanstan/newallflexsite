<?php namespace Repositories;

use Entities\SensorReading;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnimalReadingSymptomRepository extends AbstractRepository implements AnimalReadingSymptomRepositoryInterface
{
    protected $classname = 'Entities\SensorReadingSymptom';
    
    protected $repository;
        
    protected $reading;
    
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function all()
    {             
        if($this->sensorReading)
        {
            return $this->sensorReading->symptom()->get();
        }

        return parent::all();
    }
    
    public function get($id)
    {
        if($id)
        {
            return $this->sensorReading->symptom ? $this->sensorReading->symptom()->findOrFail($id) : parent::get($id);
        }

    }
    
    public function create($input)
    {

            /**
            * @var \Entities\Device
            */
            $symptom = parent::create($input);
            
            $symptom->reading()->associate($this->sensorReading);
            
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
        $this->sensorReading = $reading;

        return $this;
    }
   
}

?>
