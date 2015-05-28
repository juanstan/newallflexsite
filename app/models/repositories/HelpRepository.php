<?php namespace Repositories;

class HelpRepository extends AbstractRepository implements HelpRepositoryInterface
{
    protected $classname = 'Entities\Help';

    public function all()
    {
        if($this)
        {
            return $this->help()->get();
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
