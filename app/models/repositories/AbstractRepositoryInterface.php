<?php namespace App\Models\Repositories;

interface AbstractRepositoryInterface
{

	public function all();

	public function create($input);

	public function delete($id);

	public function get($id);

	public function getCreateValidator($input);

	public function getUpdateValidator($input);

	public function update($id, $input);

}

?>
