<?php namespace Repositories;

use Entities\sensorReading;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnimalReadingRepository extends AbstractRepository implements AnimalReadingRepositoryInterface
{
    protected $classname = 'Entities\SensorReading';
    
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
            return $this->animal->sensorReadings()->orderBy('reading_time')->get();
        }

        return parent::all();
    }
    
    
    public function get($id)
    {
        if($id)
        {
            return $this->animal ? $this->animal->sensorReadings()->findOrFail($id) : parent::get($id);
        }

    }
    
    public function create($input)
    {

            $reading = parent::create($input);
            
            $reading->animal()->associate($this->animal); 
            
            $reading->save();
                 

        return $reading;
    }

    public function getCreateValidator($input)
    {
        return \Validator::make($input,
        [
            'temperature' => ['required']
        ]);
    }


    public function getUpdateValidator($input)
    {
        return \Validator::make($input,
        [
            'temperature' => ['sometimes','required'],
        ]);
    }
    
    public function setAnimal($animal)
    {
        $this->animal = $animal;

        return $this;
    }
    
    public function update($id, $input)
    {
        
        $object = $this->animal->sensorReadings()->where('created_at', '>=', \Carbon\Carbon::now()->subSeconds(30))->findOrFail($id);
        
        $object->fill($input);
        $object->save();

        return $object;
        
    }
    
    public function updateTimeout($input)
    {
        $this->created_at->addSeconds(30);

        return $this;
    }
   
}

?>
