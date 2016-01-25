<?php namespace App\Models\Repositories;

use App\Models\Entities\Reading;
use App\Models\Entities\ReadingSymptom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PetReadingSymptomRepository extends AbstractRepository implements PetReadingSymptomRepositoryInterface
{
    protected $model;
    protected $userRepo;
    protected $readings;

    public function __construct(ReadingSymptom $model, UserRepositoryInterface $user)
    {
        $this->userRepo = $user;
        $this->model = $model;
    }
    
    public function all()
    {             
        if($this->readings)
        {
            return $this->readings->symptoms()->get();
        }

        return parent::all();
    }
    
    public function get($id)
    {
        if($id)
        {
            return $this->readings->symptoms ? $this->readings->symptoms()->findOrFail($id) : parent::get($id);
        }

    }
    
    public function create($input)
    {
        $symptom = parent::create($input);
        $symptom->reading()->associate($this->readings);
        $symptom->save();

        return $symptom;
    }

    public function getCreateValidator($input)
    {
        return \Validator::make($input,
        [
            'symptom_id' => ['required','integer','exists:symptoms,id','unique:reading_symptom,symptom_id,NULL,id,reading_id,'.$input['reading_id']]
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
        $this->readings = $reading;
        return $this;
    }


    public function deleteBySymptomIdForReading($reading, $symptomId)
    {
        $readingSymptoms = $this->resreadingSymptoms()->where('symptom_id', '=', $symptomId)->get();
        foreach($readingSymptoms as $readingSymptom)
        {
            $readingSymptom->delete();
        }

    }

}

?>
