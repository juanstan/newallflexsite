<?php namespace App\Models\Repositories;

use Validator;
use App\Models\Entities\Reading;

class ReadingRepository extends AbstractRepository implements ReadingRepositoryInterface
{
	protected $model;

	public function __construct(Reading $model){
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


	public function synchroniseSymptoms($readingId, $symptoms) {
		$this->get($readingId)->symptoms()->sync($symptoms);

	}


	public function removeSymptom($readingId, $symptom_id) {
		return $this->get($readingId)->symptoms()->detach($symptom_id);

	}

}

?>
