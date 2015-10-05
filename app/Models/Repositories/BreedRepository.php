<?php namespace App\Models\Repositories;

use Validator;

class BreedRepository extends AbstractRepository implements SymptomRepositoryInterface
{
	protected $classname = 'App\Models\Entities\Breed';

	public function getBreedIdByName($breedName)
	{
		return $this->query()->where('name', '=', $breedName)->first();
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
