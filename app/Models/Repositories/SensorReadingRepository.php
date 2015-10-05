<?php namespace App\Models\Repositories;

use Validator;

class SensorReadingRepository extends AbstractRepository implements SymptomRepositoryInterface
{
	protected $classname = 'App\Models\Entities\SensorReading';

	public function removeByAnimalId($animalId)
	{
		$this->query()->where('animal_id', '=', $animalId)->delete();
	}

	public function getByAnimalId($id)
	{

		return $this->query()
				->where('animal_id', '=', $id)
				->firstOrFail();

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
