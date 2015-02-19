<?php namespace Repositories;

interface AbstractRepositoryInterface
{
	public function all();

	/**
	* @return \Illuminate\Database\Eloquent\Model
	*/
	public function create($input);

	/**
	* @throws \Illuminate\Database\Eloquent\ModelNotFoundException
	*/
	public function delete($id);

	/**
	* @throws \Illuminate\Database\Eloquent\ModelNotFoundException
	* @return \Illuminate\Database\Eloquent\Model
	*/
	public function get($id);

	/**
	* @return \Illuminate\Validation\Validator
	*/
	public function getCreateValidator($input);

	/**
	* @return \Illuminate\Validation\Validator
	*/
	public function getUpdateValidator($input);

	/**
	* @throws \Illuminate\Database\Eloquent\ModelNotFoundException
	*/
	public function update($id, $input);
}

?>
