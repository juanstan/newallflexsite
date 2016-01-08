<?php namespace App\Models\Repositories;

use Validator;
use App\Models\Entities\Symptom;

class SymptomRepository extends AbstractRepository implements SymptomRepositoryInterface
{
	//protected $classname = 'App\Models\Entities\Symptom';
	protected $model;

	public function __construct(Symptom $model)
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
