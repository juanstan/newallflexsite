<?php namespace App\Models\Repositories;

use Validator;
use App\Models\Entities\Condition;

class ConditionRepository extends AbstractRepository implements SymptomRepositoryInterface
{
	//protected $classname = 'App\Models\Entities\Condition';

	protected $model;

	public function __construct(Condition $model)
	{
		$this->model = $model;
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
