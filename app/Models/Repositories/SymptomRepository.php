<?php namespace App\Models\Repositories;

use Validator;

class SymptomRepository extends AbstractRepository implements SymptomRepositoryInterface
{
	protected $classname = 'App\Models\Entities\Symptom';

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
