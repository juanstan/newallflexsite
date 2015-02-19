<?php namespace Repositories;

use Entities\Reading;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AnimalReadingSymptomRepository extends AbstractRepository implements AnimalReadingSymptomRepositoryInterface
{
    protected $classname = 'Entities\Symptom';
    
    protected $repository;
        
    protected $reading;
    
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    public function all()
    {             
        if($this->reading)
        {
            return $this->reading->symptom()->get();
        }

        return parent::all();
    }
    
    public function get($id)
    {
        if($id)
        {
            return $this->reading->symptom ? $this->reading->symptom()->findOrFail($id) : parent::get($id);
        }

    }
    
    public function create($input)
    {

            /**
            * @var \Entities\Device
            */
            $symptom = parent::create($input);
            
            $symptom->reading()->associate($this->reading); 
            
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
        $this->reading = $reading;

        return $this;
    }
   
}

?>
