<?php namespace App\Models\Repositories;

use Validator;
use App\Models\Entities\Breed;

class BreedRepository extends AbstractRepository implements BreedRepositoryInterface
{

	protected $model;

	public function __construct(Breed $model)
	{
		$this->model = $model;
	}

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
