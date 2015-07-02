<?php namespace App\Models\Repositories;

use App\Models\Entities\Vet;

class VetRepository extends AbstractRepository implements VetRepositoryInterface
{
	protected $classname = 'App\Models\Entities\Vet';

	public function getByEmailForLogin($email)
	{
		return Vet::with('tokens')
			->where('email', '=', $email)
			->firstOrFail();
	}

	public function getVetDetails($id)
	{
		return Vet::findOrFail($id);
	}

	public function getCreateValidator($input)
	{
		return \Validator::make($input,
		[
			'email'    => ['required','unique:vets'],
            'password'      => ['required','min:6','confirmed'],
            'password_confirmation' => ['required','min:6']
		]);
	}

	public function getLoginValidator($input)
	{
		return \Validator::make($input,
		[
			'email' => ['required','email','exists:vets'],
			'password'      => ['required','min:6']
		]);
	}

	public function getUpdateValidator($input, $id = null)
	{
		return \Validator::make($input,
		[
            'email' => ['sometimes','required','email','unique:vets,email,'.$id],
			'first_name'    => ['sometimes','required'],
			'last_name'     => ['sometimes','required'],
            'old_password'      => ['min:6'],
            'password'      => ['min:6','confirmed','different:old_password'],
            'password_confirmation' => ['min:6'],
		]);
	}
}

?>
