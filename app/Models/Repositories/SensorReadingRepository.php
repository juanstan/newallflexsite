<?php namespace App\Models\Repositories;

use Validator;
use App\Models\Entities\SensorReading;

class SensorReadingRepository extends AbstractRepository implements SymptomRepositoryInterface
{
	//protected $classname = 'App\Models\Entities\SensorReading';
	protected $model;

	public function __construct(SensorReading $model){
		$this->model = $model;
	}

	public function removeByPetId($petId)
	{
		$this->query()->where('pet_id', '=', $petId)->delete();
	}

	public function getByPetId($id)
	{

		return $this->query()
				->where('pet_id', '=', $id)
				->first();

	}

	public function getCreateValidator($input)
	{
		return Validator::make($input,
				[
					
				]);
	}


	public function getUpdateValidator($input)
	{
		return Validator::make($input,
				[

				]);
	}

}

?>
