<?php namespace App\Models\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
	//protected $classname = 'Model';

	public function all()
	{
		//return call_user_func_array([$this->classname, 'all'], []);
		return $this->model->all();
	}

	public function create($input)
	{
		//return call_user_func_array([$this->classname, 'create'], [$input]);
		return $this->model->create($input);
	}

	public function delete($id)
	{
		$object = $this->get($id);
		$object->delete();
	}

	public function get($id)
	{
		//return call_user_func_array([$this->classname, 'findOrFail'], [$id]);
		return $this->model->findOrFail($id);
	}

	abstract public function getCreateValidator($input);

	abstract public function getUpdateValidator($input);

	/**
	* @returns \Illuminate\Database\Eloquent\Builder
	*/
	public function query()
	{
		/*$class = $this->classname;
		return (new $class)->newQuery();*/
		return $this->model->newQuery();
	}

	public function update($id, $input)
	{
		$object = $this->get($id);
		$object->fill($input);
		$object->save();

		return $object;
	}
}

?>
