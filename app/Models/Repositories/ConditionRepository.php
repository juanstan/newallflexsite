<?php namespace App\Models\Repositories;

use Validator;

class ConditionRepository extends AbstractRepository implements SymptomRepositoryInterface
{
	protected $classname = 'App\Models\Entities\Condition';

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
