<?php namespace App\Models\Repositories;

use Validator;

class SensorReadingRepository extends AbstractRepository implements SymptomRepositoryInterface
{
	protected $classname = 'App\Models\Entities\SensorReading';

	public function removeByPetId($petId)
	{
		$this->query()->where('pet_id', '=', $petId)->delete();
	}

	public function getByPetId($id)
	{

		return $this->query()
				->where('pet_id', '=', $id)
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
