<?php namespace App\Models\Repositories;

use Validator;
use Cache;
use App\Models\Entities\Condition;

class ConditionRepository extends AbstractRepository implements ConditionRepositoryInterface
{
	protected $model;

	public function __construct(Condition $model)
	{
		$this->model = $model;
	}

	public function all()
	{
		return Cache::remember('conditions', 10, function()
		{
			return $this->model->all();
		});

	}


	public function getCreateValidator($input)
	{
		return Validator::make($input,
				[
					'condition_id' => ['required','exists:conditions,id']
				]);
	}


	public function getUpdateValidator($input)
	{
		return Validator::make($input,
				[
					'condition_id' => ['required']
				]);
	}


}

?>
